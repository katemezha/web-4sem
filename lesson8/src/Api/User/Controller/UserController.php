<?php

declare(strict_types=1);

namespace App\Api\User\Controller;

use App\Api\User\Dto\AdressResponseDto;
use App\Api\User\Dto\UserCreateRequestDto;
use App\Api\User\Dto\UserListResponseDto;
use App\Api\User\Dto\UserResponseDto;
use App\Api\User\Dto\UserUpdateRequestDto;
use App\Api\User\Dto\ValidationExampleRequestDto;
use App\Core\Common\Dto\ValidationFailedResponse;
use App\Core\User\Document\Adress;
use App\Core\User\Document\User;
use App\Core\User\Enum\Permission;
use App\Core\User\Enum\Role;
use App\Core\User\Enum\RoleHumanReadable;
use App\Core\User\Repository\AdressRepository;
use App\Core\User\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Route("/users")
 */
class UserController extends AbstractController
{
    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"GET"})
     *
     * @IsGranted(Permission::USER_SHOW)
     *
     * @ParamConverter("user")
     *
     * @Rest\View()
     *
     * @param User|null $user
     *
     * @return UserResponseDto
     */
    public function show(User $user = null, AdressRepository $adressRepository)
    {
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $adress = $adressRepository->findOneBy(['user' => $user]);

        return $this->createUserResponse($user, $adress);
    }

    /**
     * @Route(path="", methods={"GET"})
     * @IsGranted(Permission::USER_INDEX)
     * @Rest\View()
     *
     * @return UserListResponseDto|ValidationFailedResponse
     */
    public function index(
        Request $request,
        UserRepository $userRepository
    ): UserListResponseDto {
        $page     = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $users = $userRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new UserListResponseDto(
            ... array_map(
                    function (User $user) {
                        return $this->createUserResponse($user);
                    },
                    $users
                )
        );
    }

    /**
     * @Route(path="", methods={"POST"})
     * @IsGranted(Permission::USER_CREATE)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View(statusCode=201)
     *
     * @param UserCreateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param UserRepository                   $userRepository
     *
     * @return UserResponseDto|ValidationFailedResponse|Response
     */
    public function create(
        UserCreateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        UserRepository $userRepository
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        if ($user = $userRepository->findOneBy(['phone' => $requestDto->phone])) {
            return new Response('User already exists', Response::HTTP_BAD_REQUEST);
        }

        $user = new User(
            $requestDto->phone,
            $requestDto->roles,
            $requestDto->apiToken
        );
        $user->setFirstName($requestDto->firstName);
        $user->setLastName($requestDto->lastName);

        $userRepository->save($user);

        return $this->createUserResponse($user);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"PUT"})
     * @IsGranted(Permission::USER_UPDATE)
     * @ParamConverter("user")
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @param UserUpdateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param UserRepository                   $userRepository
     *
     * @return UserResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        User $user = null,
        UserUpdateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        UserRepository $userRepository
    ) {
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        $user->setFirstName($requestDto->firstName);
        $user->setLastName($requestDto->lastName);

        $userRepository->save($user);

        return $this->createUserResponse($user);
    }

    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"DELETE"})
     * @IsGranted(Permission::USER_DELETE)
     * @ParamConverter("user")
     *
     * @Rest\View()
     *
     * @param User|null      $user
     * @param UserRepository $userRepository
     *
     * @return UserResponseDto|ValidationFailedResponse
     */
    public function delete(
        UserRepository $userRepository,
        User $user = null
    ) {
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $userRepository->remove($user);
    }

    private function getRoleHumanReadable(User $user): ?string
    {
        if (in_array(Role::ADMIN, $user->getRoles(), true)) {
            return RoleHumanReadable::ADMIN;
        }

        if (in_array(Role::USER, $user->getRoles(), true)) {
            return RoleHumanReadable::USER;
        }

        return null;
    }

    /**
     * @Route(path="/validation", methods={"POST"})
     * @IsGranted(Permission::USER_VALIDATION)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @return ValidationExampleRequestDto|ValidationFailedResponse
     */
    public function validation(
        ValidationExampleRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors
    ) {
        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        return $requestDto;
    }

    /**
     * @param User         $user
     * @param Adress|null $adress
     *
     * @return UserResponseDto
     */
    private function createUserResponse(User $user, ?Adress $adress = null): UserResponseDto
    {
        $dto = new UserResponseDto();

        $dto->id                = $user->getId();
        $dto->name         = $user->getFirstName();
        $dto->surname          = $user->getLastName();
        $dto->phone             = $user->getPhone();
        $dto->roles = $this->getRoleHumanReadable($user);
        $dto->token             = $user->getApiToken();

        if ($adress) {
            $adressResponseDto        = new AdressResponseDto();
            $adressResponseDto->id    = $adress->getId();
            $adressResponseDto->city = $adress->getCity();
            $adressResponseDto->street  = $adress->getStreet();

            $dto->adress = $adressResponseDto;
        }

        return $dto;
    }
}

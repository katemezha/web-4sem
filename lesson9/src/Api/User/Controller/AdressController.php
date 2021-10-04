<?php

declare(strict_types=1);

namespace App\Api\Adress\Controller;

use App\Api\Adress\Dto\AdressCreateRequestDto;
use App\Api\Adress\Dto\AdressListResponseDto;
use App\Api\Adress\Dto\AdressResponseDto;
use App\Api\Adress\Dto\AdressUpdateRequestDto;
use App\Api\Adress\Dto\ValidationExampleRequestDto;
use App\Api\Adress\Factory\ResponseFactory;
use App\Core\Common\Dto\ValidationFailedResponse;
use App\Core\Common\Factory\HTTPResponseFactory;
use App\Core\Adress\Document\Contact;
use App\Core\Adress\Document\Adress;
use App\Core\Adress\Enum\Permission;
use App\Core\Adress\Repository\ContactRepository;
use App\Core\Adress\Repository\AdressRepository;
use App\Core\Adress\Service\AdressService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @Route("/adress")
 */
class AdressController extends AbstractController
{
    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"GET"})
     *
     * @IsGranted(Permission::ADRESS_SHOW)
     *
     * @ParamConverter("adress")
     *
     * @Rest\View()
     *
     * @param Adress|null         $adress
    
     * @param ResponseFactory   $responseFactory
     *
     * @return AdressResponseDto
     */
    public function show( Adress $adress = null, UserRepository $userRepository, ResponseFactory $responseFactory)
    {
        if (!$adress) {
            throw $this->createNotFoundException('Adress not found');
        }

        $user = $userRepository->findOneBy(['name' => $users->getUser()]);

        return $responseFactory->createAdressResponse($adress, $user);
    }

     /**
     * @Route(path="", methods={"GET"})
     * @IsGranted(Permission::PRODUCT_INDEX)
     * @Rest\View()
     *
     * @return AdressListResponseDto|ValidationFailedResponse
     */
    public function index(
        Request $request,
        AdressRepository $adressRepository,
        ResponseFactory $responseFactory
    ): AdressListResponseDto {
        $page     = (int)$request->get('page');
        $quantity = (int)$request->get('slice');

        $adresss = $adressRepository->findBy([], [], $quantity, $quantity * ($page - 1));

        return new AdressListResponseDto(
            ... array_map(
                    function (Adress $adress) use ($responseFactory) {
                        return $responseFactory->createAdressResponse($adress, null);
                    },
                    $adresss
                )
        );
    }

      /**
     * @Route(path="", methods={"POST"})
     * @IsGranted(Permission::PRODUCT_CREATE)
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View(statusCode=201)
     *
     * @param AdressCreateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param AdressService                   $adressService
     *
     * @return AdressResponseDto|ValidationFailedResponse|Response
     */
    public function create(
        AdressCreateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        AdressService $adressService,
        ResponseFactory $responseFactory,
        HTTPResponseFactory $HTTPResponseFactory
    ) {
        if ($validationErrors->count() > 0) {
            return $HTTPResponseFactory->createValidationFailedResponse($validationErrors);
        }


        return $responseFactory->createAdressResponse($adressService->createAdress($requestDto), null);
    }



    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"PUT"})
     * @IsGranted(Permission::ADRESS_UPDATE)
     * @ParamConverter("user")
     * @ParamConverter("requestDto", converter="fos_rest.request_body")
     *
     * @Rest\View()
     *
     * @param Adress|null                        $adress
     * @param AdressUpdateRequestDto             $requestDto
     * @param ConstraintViolationListInterface $validationErrors
     * @param AdressRepository                   $adressRepository
     * @param ResponseFactory                  $responseFactory
     *
     * @return AdressResponseDto|ValidationFailedResponse|Response
     */
    public function update(
        Adress $adress = null,
        AdressUpdateRequestDto $requestDto,
        ConstraintViolationListInterface $validationErrors,
        AdressService $adressService,
        ResponseFactory $responseFactory
    ) {
        if (!$adress) {
            throw $this->createNotFoundException('Adress not found');
        }

        if ($validationErrors->count() > 0) {
            return new ValidationFailedResponse($validationErrors);
        }

        return $responseFactory->createAdressResponse($adressService->updateAdress($requestDto));
    }

   
    
    /**
     * @Route(path="/{id<%app.mongo_id_regexp%>}", methods={"DELETE"})
     * @IsGranted(Permission::PRODUCT_DELETE)
     * @ParamConverter("user")
     *
     * @Rest\View()
     *
     * @param Adress|null      $adress
     * @param AdressRepository $adressRepository
     *
     * @return AdressResponseDto|ValidationFailedResponse
     */
    public function delete(
        AdressRepository $adressRepository,
        Adress $adress = null
    ) {
        if (!$adress) {
            throw $this->createNotFoundException('Adress not found');
        }

        $adressRepository->remove($adress);
    }

    /**
     * @Route(path="/validation", methods={"POST"})
     * @IsGranted(Permission::PRODUCT_VALIDATION)
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

}

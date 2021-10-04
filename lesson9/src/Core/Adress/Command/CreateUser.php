<?php

declare(strict_types=1);

namespace App\Core\Adress\Command;

use App\Core\Adress\Document\User;
use App\Core\User\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class CreateUser extends Command
{
    protected static $defaultName = 'app:core:create-user-adress';

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
    }

    protected function configure()
    {
        $this
        ->setDescription('Creates a new user.')
        ->setHelp('This command allows you to create a user...')
        ->addOption('first_name', null, InputOption::VALUE_OPTIONAL, 'First name')
        ->addOption('last_name', null, InputOption::VALUE_OPTIONAL, 'Last name')
        ->addOption('email', null, InputOption::VALUE_OPTIONAL, 'Email')
        ->addOption('city_id', null, InputOption::VALUE_OPTIONAL, 'City ID')
        ->addOption('phone', null, InputOption::VALUE_OPTIONAL, 'Phone')
        ->addOption('roles', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Roles');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($user = $this->UserRepository->findOneBy(['name' => $input->getOption('name')])) {
            $output->writeln(
                [
                    'User already exists!',
                    '============',
                    $this->formatUserLine($user),
                ]
            );

            return Command::SUCCESS;
        }

        $user = new User(
          
            $input->getOption('first_name'),
            $input->getOption('last_name'),
            $input->getOption('email'),
            $input->getOption('city_id'),
            $input->getOption('phone'),
            $input->getOption('roles')
        );
        $user->setFirstName($input->getOption('first_name'));
        $user->setLastName($input->getOption('last_name'));
        $user->setEmail($input->getOption('email'));
        $user->setCityId($input->getOption('city_id'));
        $user->setPhone($input->getOption('phone'));
        $user->setRoles($input->getOption('roles'));

        $this->userRepository->save($user);

        $output->writeln(
            [
                'User is created!',
                '============',
                $this->formatUserLine($user),
            ]
        );

        return Command::SUCCESS;
    }

    private function formatUserLine(User $user): string
    {
        return sprintf(
            'id: %s, name: %s, first_name: %s, last_name: %s, email: %s, birthdate: %s, rating: %s, age: %s, city_id: %s, reg_date: %s, phone: %s, roles: %s',
            $user->getId(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getCityId(),
            $user->getPhone(),
            implode(',', $user->getRoles()),
        );
    }
}

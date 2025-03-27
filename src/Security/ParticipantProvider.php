<?php
//
//namespace App\Security;
//use App\Entity\Participant;
//use App\Repository\ParticipantRepository;
//use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
//use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
//use Symfony\Component\Security\Core\User\UserInterface;
//use Symfony\Component\Security\Core\User\UserProviderInterface;
//class ParticipantProvider implements UserProviderInterface
//{
//    private $participantRepository;
//
//    public function __construct(ParticipantRepository $participantRepository)
//    {
//        $this->participantRepository = $participantRepository;
//    }
//
//    public function loadUserByUsername(string $usernameOrEmail): UserInterface
//    {
//        $participant = $this->participantRepository->findByUsernameOrEmail($usernameOrEmail);
//
//        if (!$participant) {
//            throw new UsernameNotFoundException(sprintf('Username or Email "%s" does not exist.', $usernameOrEmail));
//        }
//
//        return $participant;
//    }
//
//    public function refreshUser(UserInterface $user)
//    {
//        if (!$user instanceof Participant) {
//            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
//        }
//
//        return $this->loadUserByUsername($user->getUsername());
//    }
//
//    public function supportsClass(string $class)
//    {
//        return Participant::class === $class;
//    }
//}
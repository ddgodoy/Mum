<?php

namespace AppBundle\Services;

use Customer\Customer\CustomerInterface;
use Customer\Customer\CustomerProfileInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class CustomerProfile
 *
 * @package AppBundle\Services
 */
class CustomerProfile
{
    /**
     * @var string
     */
    private $avatarBasePath;

    /**
     * @var string
     */
    private $avatarBaseURL;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * CustomerProfile constructor.
     *
     * @param string $avatarBasePath
     * @param string $avatarBaseURL
     * @param EntityManager $em
     */
    public function __construct($avatarBasePath, $avatarBaseURL, EntityManager $em)
    {
        $this->avatarBasePath = $avatarBasePath;
        $this->avatarBaseURL = $avatarBaseURL;
        $this->em = $em;
    }

    /**
     * Update the customer profile with the given display name and store the avatar data into file
     * and store the compose url
     *
     * @param CustomerInterface $customer
     * @param CustomerProfileInterface $customerProfile
     * @param string $avatarData
     * @param string $mimeType
     * @return bool
     */
    public function update(CustomerInterface $customer, CustomerProfileInterface $customerProfile, $avatarData, $mimeType)
    {
        $fileName = uniqid(sprintf('customer%sAvatar', $customer->getId()));
        $fileFullName = sprintf('%s.%s', $fileName, $mimeType);
        // if the profile already has an avatar use the same file and replace it
        $currentName = $customerProfile->getAvatarURL();
        if ($currentName) {
            $base = sprintf('%s%s', $this->avatarBaseURL, $this->avatarBasePath);
            $startPos = strpos($currentName, $base) + strlen($base);
            $fileFullName = substr($currentName, $startPos);
        }
        $fileFullPath = sprintf('%s%s', $this->avatarBasePath, $fileFullName);
        if (!file_put_contents($fileFullPath, base64_decode($avatarData))) {
            return false;
        }

        $fileFullURL = sprintf('%s%s', $this->avatarBaseURL, $fileFullPath);
        $customerProfile->setAvatarURL($fileFullURL);

        $customerProfile->setCustomer($customer);
        $customer->setProfile($customerProfile);

        $this->em->persist($customerProfile);
        $this->em->flush();
    }
}
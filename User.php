<?php
/**
 * Created by IntelliJ IDEA.
 * User: Abo-norah91
 * Date: 2/9/18
 * Time: 8:08 PM
 */

class User
{

    private $userId;
    private $userName;
    private $userFirstName;
    private $userLastName;
    private $userEmail;
    private $userPassword;
    private $creditCardNumber;
    private $cardHolderName;
    private $cardExperationDate;
    private $ccv;

    /**
     * User constructor.
     * @param $userId
     * @param $userName
     * @param $userFirstName
     * @param $userLastName
     * @param $userEmail
     * @param $userPassword
     * @param $creditCardNumber
     * @param $cardHolderName
     * @param $cardExperationDate
     * @param $ccv
     */
    public function __construct(int $userId, String $userName, String $userFirstName, String $userLastName,
                                String $userEmail, String $userPassword,
                                int $creditCardNumber, String $cardHolderName, int $cardExperationDate, int $ccv)
    {
        $this->userId = $userId;
        $this->userName = $userName;
        $this->userFirstName = $userFirstName;
        $this->userLastName = $userLastName;
        $this->userEmail = $userEmail;
        $this->userPassword = $userPassword;
        $this->creditCardNumber = $creditCardNumber;
        $this->cardHolderName = $cardHolderName;
        $this->cardExperationDate = $cardExperationDate;
        $this->ccv = $ccv;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return String
     */
    public function getUserName(): String
    {
        return $this->userName;
    }

    /**
     * @param String $userName
     */
    public function setUserName(String $userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return String
     */
    public function getUserFirstName(): String
    {
        return $this->userFirstName;
    }

    /**
     * @param String $userFirstName
     */
    public function setUserFirstName(String $userFirstName)
    {
        $this->userFirstName = $userFirstName;
    }

    /**
     * @return String
     */
    public function getUserLastName(): String
    {
        return $this->userLastName;
    }

    /**
     * @param String $userLastName
     */
    public function setUserLastName(String $userLastName)
    {
        $this->userLastName = $userLastName;
    }

    /**
     * @return String
     */
    public function getUserEmail(): String
    {
        return $this->userEmail;
    }

    /**
     * @param String $userEmail
     */
    public function setUserEmail(String $userEmail)
    {
        $this->userEmail = $userEmail;
    }

    /**
     * @return String
     */
    public function getUserPassword(): String
    {
        return $this->userPassword;
    }

    /**
     * @param String $userPassword
     */
    public function setUserPassword(String $userPassword)
    {
        $this->userPassword = $userPassword;
    }

    /**
     * @return int
     */
    public function getCreditCardNumber(): int
    {
        return $this->creditCardNumber;
    }

    /**
     * @param int $creditCardNumber
     */
    public function setCreditCardNumber(int $creditCardNumber)
    {
        $this->creditCardNumber = $creditCardNumber;
    }

    /**
     * @return String
     */
    public function getCardHolderName(): String
    {
        return $this->cardHolderName;
    }

    /**
     * @param String $cardHolderName
     */
    public function setCardHolderName(String $cardHolderName)
    {
        $this->cardHolderName = $cardHolderName;
    }

    /**
     * @return int
     */
    public function getCardExperationDate(): int
    {
        return $this->cardExperationDate;
    }

    /**
     * @param int $cardExperationDate
     */
    public function setCardExperationDate(int $cardExperationDate)
    {
        $this->cardExperationDate = $cardExperationDate;
    }

    /**
     * @return int
     */
    public function getCcv(): int
    {
        return $this->ccv;
    }

    /**
     * @param int $ccv
     */
    public function setCcv(int $ccv)
    {
        $this->ccv = $ccv;
    }




}
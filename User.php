<?php
/**
 * Created by IntelliJ IDEA.
 * User: Mohammed Alkhudhayr
 * Date: 2/9/18
 * Time: 8:08 PM
 */

class User
{

    private $user_id;
    private $user_name;
    private $user_firstName;
    private $user_lastName;
    private $Email;
    private $Password;
    private $credit_card_number;
    private $card_holder_name;
    private $credit_expiration;
    private $credit_ccv;

    /**
     * User constructor.
     * @param $user_id
     * @param $user_name
     * @param $user_firstName
     * @param $user_lastName
     * @param $Email
     * @param $Password
     * @param $credit_card_number
     * @param $card_holder_name
     * @param $credit_expiration
     * @param $credit_ccv
     */
    public function __construct(int $user_id, String $user_name, String $user_firstName, String $user_lastName,
                                String $Email, String $Password,
                                int $credit_card_number, String $card_holder_name, int $credit_expiration, int $credit_ccv)
    {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->user_firstName = $user_firstName;
        $this->user_lastName = $user_lastName;
        $this->Email = $Email;
        $this->Password = $Password;
        $this->credit_card_number = $credit_card_number;
        $this->card_holder_name = $card_holder_name;
        $this->credit_expiration = $credit_expiration;
        $this->credit_ccv = $credit_ccv;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return String
     */
    public function getUserName(): String
    {
        return $this->user_name;
    }

    /**
     * @param String $user_name
     */
    public function setUserName(String $user_name)
    {
        $this->user_name = $user_name;
    }

    /**
     * @return String
     */
    public function getUserFirstName(): String
    {
        return $this->user_firstName;
    }

    /**
     * @param String $user_firstName
     */
    public function setUserFirstName(String $user_firstName)
    {
        $this->user_firstName = $user_firstName;
    }

    /**
     * @return String
     */
    public function getUserLastName(): String
    {
        return $this->user_lastName;
    }

    /**
     * @param String $user_lastName
     */
    public function setUserLastName(String $user_lastName)
    {
        $this->user_lastName = $user_lastName;
    }

    /**
     * @return String
     */
    public function getUserEmail(): String
    {
        return $this->Email;
    }

    /**
     * @param String $Email
     */
    public function setUserEmail(String $Email)
    {
        $this->Email = $Email;
    }

    /**
     * @return String
     */
    public function getUserPassword(): String
    {
        return $this->Password;
    }

    /**
     * @param String $Password
     */
    public function setUserPassword(String $Password)
    {
        $this->Password = $Password;
    }

    /**
     * @return int
     */
    public function getCreditCardNumber(): int
    {
        return $this->credit_card_number;
    }

    /**
     * @param int $credit_card_number
     */
    public function setCreditCardNumber(int $credit_card_number)
    {
        $this->credit_card_number = $credit_card_number;
    }

    /**
     * @return String
     */
    public function getCardHolderName(): String
    {
        return $this->card_holder_name;
    }

    /**
     * @param String $card_holder_name
     */
    public function setCardHolderName(String $card_holder_name)
    {
        $this->card_holder_name = $card_holder_name;
    }

    /**
     * @return int
     */
    public function getCardExperationDate(): int
    {
        return $this->credit_expiration;
    }

    /**
     * @param int $credit_expiration
     */
    public function setCardExperationDate(int $credit_expiration)
    {
        $this->credit_expiration = $credit_expiration;
    }

    /**
     * @return int
     */
    public function getCcv(): int
    {
        return $this->credit_ccv;
    }

    /**
     * @param int $credit_ccv
     */
    public function setCcv(int $credit_ccv)
    {
        $this->credit_ccv = $credit_ccv;
    }




}
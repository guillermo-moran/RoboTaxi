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
    private $email;
    private $password;
    private $credit_card_number;
    private $credit_card_username;
    private $credit_expiration;
    private $credit_ccv;

    /**
     * User constructor.
     * @param $user_id
     * @param $user_name
     * @param $user_firstName
     * @param $user_lastName
     * @param $email
     * @param $password
     * @param $credit_card_number
     * @param $credit_card_username
     * @param $credit_expiration
     * @param $credit_ccv
     */
    public function __construct(int $user_id, String $user_name, String $user_firstName, String $user_lastName,
                                String $email, String $password,
                                int $credit_card_number, String $credit_card_username, int $credit_expiration, int $credit_ccv)
    {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->user_firstName = $user_firstName;
        $this->user_lastName = $user_lastName;
        $this->email = $email;
        $this->password = $password;
        $this->credit_card_number = $credit_card_number;
        $this->credit_card_username = $credit_card_username;
        $this->credit_expiration = $credit_expiration;
        $this->credit_ccv = $credit_ccv;
    }

    /**
     * @return int
     */
    public function getUserId()
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
    public function getUserName()
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
    public function getUserFirstName()
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
    public function getUserLastName()
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
    public function getUserEmail()
    {
        return $this->email;
    }

    /**
     * @param String $email
     */
    public function setUserEmail(String $email)
    {
        $this->email = $email;
    }

    /**
     * @return String
     */
    public function getUserPassword()
    {
        return $this->password;
    }

    /**
     * @param String $password
     */
    public function setUserPassword(String $password)
    {
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getCreditCardNumber()
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
    public function getCardHolderName()
    {
        return $this->credit_card_username;
    }

    /**
     * @param String credit_card_username
     */
    public function setCardHolderName(String $credit_card_username)
    {
        $this->credit_card_username = $credit_card_username;
    }

    /**
     * @return int
     */
    public function getCardExperationDate()
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
    public function getCcv()
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

?>
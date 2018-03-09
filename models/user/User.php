<?php
/**
 * Created by IntelliJ IDEA.
 * User: Mohammed Alkhudhayr
 * Date: 2/9/18
 * Time: 8:08 PM
 */
//
//class User
//{
//
//    private $user_id;
//    private $user_name;
//    private $user_firstName;
//    private $user_lastName;
//    private $email;
//    private $password;
//    private $credit_card_number;
//    private $card_holder_name;
//    private $credit_expiration;
//    private $credit_ccv;
//
//    /**
//     * User constructor.
//     * @param $user_id
//     * @param $user_name
//     * @param $user_firstName
//     * @param $user_lastName
//     * @param $email
//     * @param $password
//     * @param $credit_card_number
//     * @param $card_holder_name
//     * @param $credit_expiration
//     * @param $credit_ccv
//     */
//    public function __construct(int $user_id, String $user_name, String $user_firstName, String $user_lastName,
//                                String $email, String $password,
//                                int $credit_card_number, String $card_holder_name, int $credit_expiration, int $credit_ccv)
//    {
//        $this->user_id = $user_id;
//        $this->user_name = $user_name;
//        $this->user_firstName = $user_firstName;
//        $this->user_lastName = $user_lastName;
//        $this->email = $email;
//        $this->password = $password;
//        $this->credit_card_number = $credit_card_number;
//        $this->card_holder_name = $card_holder_name;
//        $this->credit_expiration = $credit_expiration;
//        $this->credit_ccv = $credit_ccv;
//    }
//
//    /**
//     * @return int
//     */
//    public function getUserId()
//    {
//        return $this->user_id;
//    }
//
//    /**
//     * @param int $user_id
//     */
//    public function setUserId(int $user_id)
//    {
//        $this->user_id = $user_id;
//    }
//
//    /**
//     * @return String
//     */
//    public function getUserName()
//    {
//        return $this->user_name;
//    }
//
//    /**
//     * @param String $user_name
//     */
//    public function setUserName(String $user_name)
//    {
//        $this->user_name = $user_name;
//    }
//
//    /**
//     * @return String
//     */
//    public function getUserFirstName()
//    {
//        return $this->user_firstName;
//    }
//
//    /**
//     * @param String $user_firstName
//     */
//    public function setUserFirstName(String $user_firstName)
//    {
//        $this->user_firstName = $user_firstName;
//    }
//
//    /**
//     * @return String
//     */
//    public function getUserLastName()
//    {
//        return $this->user_lastName;
//    }
//
//    /**
//     * @param String $user_lastName
//     */
//    public function setUserLastName(String $user_lastName)
//    {
//        $this->user_lastName = $user_lastName;
//    }
//
//    /**
//     * @return String
//     */
//    public function getUserEmail()
//    {
//        return $this->email;
//    }
//
//    /**
//     * @param String $email
//     */
//    public function setUserEmail(String $email)
//    {
//        $this->email = $email;
//    }
//
//    /**
//     * @return String
//     */
//    public function getUserPassword()
//    {
//        return $this->password;
//    }
//
//    /**
//     * @param String $password
//     */
//    public function setUserPassword(String $password)
//    {
//        $this->password = $password;
//    }
//
//    /**
//     * @return int
//     */
//    public function getCreditCardNumber()
//    {
//        return $this->credit_card_number;
//    }
//
//    /**
//     * @param int $credit_card_number
//     */
//    public function setCreditCardNumber(int $credit_card_number)
//    {
//        $this->credit_card_number = $credit_card_number;
//    }
//
//    /**
//     * @return String
//     */
//    public function getCardHolderName()
//    {
//        return $this->card_holder_name;
//    }
//
//    /**
//     * @param String credit_card_username
//     */
//    public function setCardHolderName(String $card_holder_name)
//    {
//        $this->card_holder_name = $card_holder_name;
//    }
//
//    /**
//     * @return int
//     */
//    public function getCardExperationDate()
//    {
//        return $this->credit_expiration;
//    }
//
//    /**
//     * @param int $credit_expiration
//     */
//    public function setCardExperationDate(int $credit_expiration)
//    {
//        $this->credit_expiration = $credit_expiration;
//    }
//
//    /**
//     * @return int
//     */
//    public function getCcv()
//    {
//        return $this->credit_ccv;
//    }
//
//    /**
//     * @param int $credit_ccv
//     */
//    public function setCcv(int $credit_ccv)
//    {
//        $this->credit_ccv = $credit_ccv;
//    }
//
//
//
//
//}

 class User
 {
     private $user_id;
     private $user_name;
     private $user_firstName;
     private $user_lastName;
     private $email;
     private $password;
     private $credit_card_number;
     private $card_holder_name;
     private $credit_expiration;
     private $credit_ccv;


     public function __construct(int $user_id, string $user_name, string $user_firstName, string $user_lastName, string $email, string $password, int $credit_card_number, string $card_holder_name, int $credit_expiration, int $credit_ccv)
     {
         $this -> user_id               = $user_id;
         $this -> user_name             = $user_name;
         $this -> user_firstName        = $user_firstName;
         $this -> user_lastName         = $user_lastName;
         $this -> email                 = $email;
         $this -> password              = $password;
         $this -> credit_card_number    = $credit_card_number;
         $this -> card_holder_name      = $card_holder_name;
         $this -> credit_expiration     = $credit_expiration;
         $this -> credit_ccv            = $credit_ccv;
     }

     // get functions
     public function getUser_id() : int
     {
         return $this -> user_id;
     }

     public function getUser_name() : string
     {
         return $this -> user_name;
     }

     public function getUser_firstName() : string
     {
         return $this -> user_firstName;
     }

     public function getUser_lastName() : string
     {
         return $this -> user_lastName;
     }

     public function getEmail() : string
     {
         return $this -> email;
     }

     public function getPassword() : string
     {
         return $this-> password;
     }
      public function getCredit_card_number() : int
     {
         return $this-> credit_card_number;
     }

     public function getCard_holder_name() : string
     {
         return $this-> card_holder_name;
     }
       public function getCredit_expiration() : int
     {
         return $this -> credit_expiration;
     }

     public function getCredit_ccv() : int
     {
         return $this-> credit_ccv;
     }

     //set functions
     public function setUser_id(Int $newUser_id)
     {
         $this -> user_id =  $newUser_id;
     }

     public function setUser_name(String $newuUser_name)
     {
         $this -> user_name = $newUser_name;
     }

     public function setUser_firstName(String $newUser_firstName)
     {
         $this -> user_firstName = $newUser_firstName;
     }

     public function setUser_lastName(String $newUser_lastName)
     {
         $this -> user_lastName = $newUser_lastName;
     }

     public function setEmail(String $newEmail)
     {
         $this -> email = $newEmail;
     }

     public function setPassword(String $newPassword)
     {
         $this -> password = $newPassword;
     }

     public function setCredit_card_number(Int $newCredit_card_number)
     {
         $this -> credit_card_number = $newCredit_card_number;
     }
     public function setCard_holder_name(String $newCard_holder_name)
     {
         $this -> card_holder_name = $newCard_holder_name;
     }

     public function setCredit_expiration(Int $newCredit_expiration)
     {
         $this -> credit_expiration = $newCredit_expiration;
     }

     public function setCredit_ccv(Int $newCredit_ccv)
     {
         $this -> credit_ccv = $newCredit_ccv;
     }
 }



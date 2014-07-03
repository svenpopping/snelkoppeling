<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class Login
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // create/read session, absolutely necessary
        $sid = session_id();
        if(!$sid) session_start();

        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login via post data (if user just submitted a login form)
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }

    /**
     * log in with post data
     */
    private function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli("localhost", "root", "AA3x8-fpe50-m8eeq-w4x7v-x6r8f", "snelkoppeling");

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);

                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                $sql = "SELECT id, username, email, password, admin, verified
                        FROM gegevens
                        WHERE username = '" . $user_name . "' OR email = '" . $user_name . "';";
                $result_of_login_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) {

                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();

                    // using PHP 5.5's password_verify() function to check if the provided password fits
                    // the hash of that user's password
                    if (password_verify($_POST['user_password'], $result_row->password)) {

                        // write user data into PHP SESSION (a file on your server)
                        $_SESSION['user_id'] = $result_row->id;
                        $_SESSION['user_name'] = $result_row->username;
                        $_SESSION['user_email'] = $result_row->email;
                        $_SESSION['user_login_status'] = 1;
                        $_SESSION['verified'] = $result_row->verified;
                        if(isset($result_row->admin) AND $result_row->admin == 1) {
                            $_SESSION['enable_admin'] = 1;
                        }
                    } else if (sha1($_POST['user_password']) == $result_row->password) {
                        $_SESSION['user_id'] = $result_row->id;
                        $_SESSION['user_name'] = $result_row->username;
                        $_SESSION['user_email'] = $result_row->email;
                        $_SESSION['user_login_status'] = 1;
                        $_SESSION['verified'] = $result_row->verified;
                        $_SESSION['change_password'] = 1;
                        if(isset($result_row->admin) AND $result_row->admin == 1) {
                            $_SESSION['enable_admin'] = 1;
                        }

                        $user_password_hash = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
                        $sql = "UPDATE gegevens SET password='".$user_password_hash."' WHERE username = '" . $user_name . "' OR email = '" . $user_name . "';";
                        $this->db_connection->query($sql);
                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }

    /**
     * perform the logout
     */
    public function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "You have been logged out.";

    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isAdminLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1 AND isset($_SESSION['enable_admin']) AND $_SESSION['enable_admin'] == 1) {
            return true;
        }
        // default return
        return false;
    }
}

**Documentation for the GuMi Academic Management System**
<?
1. Environment Set-up
        CakePHP 3.x installation requirements (for this server):
                1.PHP 5.6.23 and Apache (installed together with XAMPP)
                2.Composer
                        When using composer to initiate new projects, there will be problems with intl, the international module in PHP,
                        the solution is as follow
                                Solution Xampp (Windows)
                                1.Open /xampp/php/php.ini
                                2.Change ;extension=php_intl.dll to  extension=php_intl.dll (remove the semicolon)
                                3.(Copy all the /xamp/php/ic*.dll files to /xampp/apache/bin) //this may not be necessary
                                4.Restart apache in the Xampp control panel
                3. MySQL and phpMyAdmin (all installed by XAMPP and can be called through browser by localhost/phpmyadmin)
        Create new Project
                In CMD move to the folder you want to put your app in and type the command below
                        "composer self-update && composer create-project --prefer-dist cakephp/app my_app_name"
        Change the hash salt setting in app.php
                the default setting is as below and we have to change this to "something long and containing lots of different values"
                'Security' => [
                    'salt' => env('SECURITY_SALT', '763a41dade810d0fa6190693589059025342d7d00f8a20f5666447e90eda1c27'),
                ],
        Testing CakePHP
                Open Apache and MySQL with XAMPP
                Run the server of CakePHP
                The testing page can be found at 'localhost'




2. basic database setting
        Connecting to database
                In phpMyAdmin we set the password and username as both "root" and then add a line in the file /xampp/phpMyAdmin/config.inc.php
                        $cfg['Servers'][$i]['auth_type'] = 'cookie';
                Besides, we have to configure the app.php file so as to match the database to CakePHP
                        'Datasources' => [
                            'default' => [
                                'className' => 'Cake\Database\Connection',
                                'driver' => 'Cake\Database\Driver\Mysql',
                                'persistent' => false,
                                'host' => 'localhost',
                                'username' => 'root',
                                'password' => 'root',
                                'database' => 'gumi_db',
                                'encoding' => 'utf8',
                                'timezone' => 'UTC',
                                'cacheMetadata' => true,
                                'log' => false,
        Configuring the database
                The chinese characters will not be displayed in phpMyAdmin, we shall write in SQL console:
                        set character_set_server=gbk;
                        alter database gumi_db character set gbk;
        Relations in the database
                use phpMyAdmin to connect tables with foreign keys




3. basic function development
        Bake
            this is used to construct a whole set of files related to the database table we are using, this will create MVC files
            e.g. the table users (User )
                After we use "cake bake" to generate files we can find three things appeared

                    'model'
                        Table
                            UsersTable.php
                        Entity
                            User.php
                    'controller'
                        UsersController
                    'template'
                        Users
                            add.ctp
                            edit.ctp
                            index.ctp
                            view.ctp
                Besides, a set of MVC files are created as well in the test folder
                The bake function is powerful especially for starter-up
                However, one should 'use' it wisely,'use' it only for the table.php file but not controllers. because this will cover the file with the new one and erase what you have done in the file. So choose wisely when you 'use' the core function "bake all"
                e.g.1 -- users table in database
                "NEVER" try to rewrite UsersController.php or UsersTable.php, they will not be influenced by the structure change in database. Besides, the four functions add, edit, view and delete are always there.
                You 'CAN' reconstruct the template, though. Because it seems more convinient to generate the front end files when the structure of the database table changes.

                e.g.2 -- groups table in database
                almost the same with users. the only difference is that in UsersTable.php there are more functions such as
                    function defaultValidation()



        Testing
                Testing functions with PHPUnit (However, I have not found this very effective, although people say this tool is marvelous)

        Version Control
                Using GitHub Desktop for version control



4. further function development
    'Login' and 'Authentication':
        login is used to decide who can get further access to the system and data instead of only visiting those 'view','index', and 'display' Pages
        authentication means to dicide the priority of different roles and distinguish 'belongings' between members of the same role
    User login
        The login function is realized with the help of User model and controller
            in the User class (users table in the database), username and password are two column that CakePHP takes good advantage of.
            it can automatically relate them with the login mechanism
        1.the function validationDefault() is responsible for finding, saving and validating any 'User' data
            stored in the file 'UsersTable,php ', which modifies the property of data format
            public function validationDefault(Validator $validator)
            {
                return $validator
                    ->notEmpty('username', 'A username is required')
                    ->notEmpty('password', 'A password is required')
                    ->notEmpty('role', 'A role is required')
                    ->add('role', 'inList', [
                        'rule' => ['inList', ['admin', 'author']],
                        'message' => 'Please enter a valid role'
                    ]);
            }
        2. the function beforeFilter in 'AppController', as a parent function, sets all access denied except for 'view', 'index' and 'display'
                this will restrict all visitors from influncing the content of the database
                Besides, the default redirect page after login and logout is also defined in AppController, below the Auth component
            then in 'UsersController', you have to "allow" users(logged in users only) for other functions such as 'logout' and 'add'
        public function beforeFilter(Event $event)
        {
            parent::beforeFilter($event);
            $this->Auth->allow(['add', 'logout']);
        }
        3.login and logout in UsersController
            public function login()
            {
                if ($this->request->is('post')) {
                    $user = $this->Auth->identify();
                    'for identify() there is an important thing we have pay attention to, we have to set the password length '
                    if ($user) {
                        $this->Auth->setUser($user);
                        return $this->redirect([
                            'controller' => 'Users',
                            'action' => 'view',
                            $user['id']
                        ]);
                    }
                    $this->Flash->error(__('Invalid username or password, try again'));
                }
            }

            public function logout()
            {
                return $this->redirect($this->Auth->logout());
            }
        4. Adding User
            the user password is hashed before stored
            this code is stored in 'User.php'
            use Cake\Auth\DefaultPasswordHasher;// add to the beginning of the file
            protected function _setPassword($password)
            {
                return (new DefaultPasswordHasher)->hash($password);
            }

        After configuring all these above, one can create new user with his own password and login and out to the system

    Authentication
    The whole authentication function is based on the controllers and models and it works together with the login function
        1. in AppController, add a line in the initialize() function, below the loadComponent Auth
            'authorize' => ['Controller'], // Used to authorize user in each table controller
            the authorization will decide which data can certain user use and edit

            and then add the function isAuthorized($user) as below
            public function isAuthorized($user)
            {
                // Admin can access every action
                if (isset($user['role']) && $user['role'] === 'admin') {
                    return true;
                }

                // Default deny
                return false;
            }
            This works as a parent class function which can be called in other controllers such as GroupsController

        2. in the controller of the database table we would like to control, such as 'groups' , we set the function isAuthorized()
            public function isAuthorized($user)
            {
                if ($this->request->action === 'add') {
                    return true;
                }

                // The owner of an group can edit and delete it
                if (in_array($this->request->action, ['edit', 'delete'])) {
                    $groupId = (int)$this->request->params['pass'][0];
                    if ($this->Groups->isOwnedBy($groupId, $user['id'])) {
                        return true;
                    }
                }
                //if they cannot decide, just return the parent function's result(false for everyone except for admin)
                return parent::isAuthorized($user);
            }

            3. we notice that in the function isAuthorized(), there is another function isOwnedBy(),
                we can find it in the file 'GroupsTable.php'
                public function isOwnedBy($groupId, $userId)
                    {
                        return $this->exists(['id' => $groupId, 'user_id' => $userId]);
                    }
                This will tell whether the group is owned by the user.

    small 'Summaries' for the above content:
        1.$this in the GroupsTable.php means the related database table groups. calling it means calling the related database table
        2.we notice that the function isOwnedBy() is stored in the file GroupsTable instead of GroupsController. But the function isAuthorized() is in the GroupsController. Why is this?
            we always want to put more in the model and less in the controller so as to divide the MVC system clearly. Models defines the behaviours and the controller tells the system how to manage and react.
            the function isAuthorized() requires a parent function in 'AppController' so as to control all behaviour of each access.
            we cannot put it in the 'GroupsTable' because we cannot put the parent function in some 'AppTable'(App does not own a table XD), putting it in the controller instead is a good way for inheritation.
            however, the function isOwnedBy() is only used by the related table in database, it can be put in the 'GroupsTable' and when it is called in 'GroupsController', no trouble will be caused. So we put it in the 'GroupsTable' to emphasis on the structure

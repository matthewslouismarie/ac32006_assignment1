<?php

session_start();

require_once( 'functions/html.php' );
require_once( 'functions/authorizations.php' );
require_once( 'classes/stores/Customer.php' );
require_once( 'classes/UserModel.php' );
require_once( 'classes/stores/User.php' );

checkIfNotLoggedIn();

$formErrors = array();
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $customer = new Customer;
  $user = new User;
  $areDetailsValid = true;
  try {
    $customer->setUsername( getPost( 'username' ) );
    $user->setUsername( getPost( 'username' ) );
  }
  catch( IllegalFormatException $e ) {
    // TODO: (minor) maybe use a custom class as need to be sure
    // that IllegalFormatException caused by sql type classes
    $formErrors[] = $e->getMessage();
    $areDetailsValid = false;
  }
  try {
    $user->setPassword( getPost( 'password' ) );
  }
  catch( IllegalFormatException $e ) {
    $formErrors[] = $e->getMessage();
    $areDetailsValid = false;
  }
  try {
    $customer->setFirstName( getPost( 'first-name' ) );
  }
  catch( IllegalFormatException $e ) {
    $formErrors[] = $e->getMessage();
    $areDetailsValid = false;
  }
  try {
    $customer->setLastName( getPost( 'last-name' ) );
  }
  catch( IllegalFormatException $e ) {
    $formErrors[] = $e->getMessage();
    $areDetailsValid = false;
  }
  try {
    $customer->setAddress( getPost( 'address' ) );
  }
  catch( IllegalFormatException $e ) {
    $formErrors[] = $e->getMessage();
    $areDetailsValid = false;
  }
  try {
    $customer->setCity( getPost( 'city' ) );
  }
  catch( IllegalFormatException $e ) {
    $formErrors[] = $e->getMessage();
    $areDetailsValid = false;
  }
  
  if ( getPost( 'title' ) !== null ) {
    try {
      $customer->setTitle( getPost( 'title' ) );
    }
    catch( IllegalFormatException $e ) {
      $formErrors[] = $e->getMessage();
      $areDetailsValid = false;
    }
  }
  
  if ( getPost( 'postcode' ) !== null ) {
    try {
      $customer->setPostcode( getPost( 'postcode' ) );
    }
    catch( IllegalFormatException $e ) {
      $formErrors[] = $e->getMessage();
      $areDetailsValid = false;
    }
  }
  
  if ( getPost( 'telephone' ) !== null ) {
    try {
      $customer->setTelephone( getPost( 'telephone' ) );
    }
    catch( IllegalFormatException $e ) {
      $formErrors[] = $e->getMessage();
      $areDetailsValid = false;
    }
  }
  
  if ( getPost( 'email' ) !== null ) {
    try {
      $customer->setEmail( getPost( 'email' ) );
    }
    catch( IllegalFormatException $e ) {
      $formErrors[] = $e->getMessage();
      $areDetailsValid = false;
    }
  }
  
  if ( $areDetailsValid ) {
    // TODO: (minor) what if user creation suceed but customer fail?
    // Customer insertion has no reason to fail though.
    //try {
      $sql = '
        INSERT INTO User ( UserId, Password)
        VALUES ( ?, ? );
      ';
      Database::query( $sql, array( $user->getUsername(),
        $user->getHashedPassword() ) );
      $sql = '
      INSERT INTO Person (
        Address,
        City,
        Email,
        FirstName,
        LastName,
        Postcode,
        Telephone,
        Title,
        UserId )
      VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ? );
      ';
      $parameters = array(
        $customer->getAddress(),
        $customer->getCity(),
        $customer->getEmail(),
        $customer->getFirstName(),
        $customer->getLastName(),
        $customer->getPostcode(),
        $customer->getTelephone(),
        $customer->getTitle(),
        $customer->getUsername()
      );
      Database::query( $sql, $parameters );
      $customer->setPersonId( Database::getConnection()->
        query( 'SELECT MAX(PersonId) FROM Person;' )->fetch()[0] );
      $sql = '
      INSERT INTO Customer ( PersonId )
      VALUE ( ? );
      ';
      Database::query( $sql, array( $customer->getPersonId() ) );
      displayMessagePage( 'Registration successful', 'Your registration was
      successful!' );
    //}
    //catch( Exception $e ) {
    //  $formErrors[] = $e->getMessage();
    //}
  }
}

?>
<!doctype html>
<html>
  <head>
    <?php displayHead() ?>
    <title>Register</title>
  </head>
  <body>
    <main>
      <h1>Register</h1>
      <p>Want to become a customer is just as easy as filling this form!</p>
      <?php displayErrors( $formErrors ); ?>
      <?php // TODO: input validation html ?>
      <?php // TODO: input types, other input properties ?>
      <table>
        <tr>
          <td><label for="username" form="form">Username</label></td>
          <td><input form="form" id="username" name="username" type="text" value="<?php echo( getPost( 'username' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="password" form="form">Password</label></td>
          <td><input form="form" id="password" name="password" type="text" value="<?php echo( getPost( 'password' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="title" form="form">Title</label></td>
          <td><input form="form" id="title" name="title" type="text" value="<?php echo( getPost( 'title' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="first-name" form="form">First Name</label></td>
          <td><input form="form" id="first-name" name="first-name" type="text" value="<?php echo( getPost( 'first-name' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="last-name" form="form">Last Name</label></td>
          <td><input form="form" id="last-name" name="last-name" type="text" value="<?php echo( getPost( 'last-name' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="address" form="form">Address</label></td>
          <td><input form="form" id="address" name="address" type="text" value="<?php echo( getPost( 'address' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="postcode" form="form">Postcode</label></td>
          <td><input form="form" id="postcode" name="postcode" type="text" value="<?php echo( getPost( 'postcode' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="city" form="form">City</label></td>
          <td><input form="form" id="city" name="city" type="text" value="<?php echo( getPost( 'city' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="telephone" form="form">Telephone</label></td>
          <td><input form="form" id="telephone" name="telephone" type="text" value="<?php echo( getPost( 'telephone' ) ) ?>" /></td>
        </tr>
        <tr>
          <td><label for="email" form="form">Email</label></td>
          <td><input form="form" id="email" name="email" type="text" value="<?php echo( getPost( 'email' ) ) ?>" /></td>
        </tr>
      </table>
      <form action="register.php" id="form" method="POST">
        <?php // TODO: (minor) add here and in other places a reset button? ?>
        <button type="submit">Register</button>
      </form>
    </main>
  </body>
</html>
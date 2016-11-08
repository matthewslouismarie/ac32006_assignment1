<?php
session_start();

require_once( 'classes/BranchManagerModel.php' );
require_once( 'classes/SalesAssistantModel.php' );
require_once( 'classes/SessionLogin.php' );
require_once( 'functions/authorizations.php' );
require_once( 'functions/html.php' );

/**
 * This page is to allow shop assistants and managers
 * to manage their details.
 */

checkIfEmployee();

$isBranchManager = BranchManagerModel::isBranchManager( SessionLogin::getUsername() );
$isSalesAssistant = SalesAssistantModel::isSalesAssistant( SessionLogin::getUsername() );

if ( $isBranchManager ) {
  $user = new BranchManagerModel();
}
else {
  $user = new SalesAssistantModel();
}
try {
  $user->setUsername( SessionLogin::getUsername() );
}
catch( DomainException $e ) {
  displayUnknownError();
  die();
}
$user->fetch();

$formErrors = array();
$isValid = true;
if ( isset( $_POST['sort-code'] ) ) {
  try {
    $user->setSortCode( $_POST['sort-code'] );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
}
if ( isset( $_POST['account-number'] ) ) {
  try {
    $user->setAccountNumber( $_POST['account-number'] );
  }
  catch( DomainException $e ) {
    $formErrors[] = $e->getMessage();
    $isValid = false;
  }
}

$user->update();
?>
<!doctype html>
<html>
  <head>
    <?php displayHead(); ?>
    <title>Your Employee Details</title>
  </head>
  <body>
    <main>
      <h1>Your staff details</h1>
      <?php displayErrors( $formErrors ) ?>
      <table>
        <tr>
          <td>Your branch: </td>
          <td><?php echo( $user->getBranchId() ) ?></td>
        </tr>
        <tr>
          <td>Your wage: </td>
          <td><?php echo( $user->getWage() ) ?></td>
        </tr>
        <tr>
          <td><label for="sort-code" form="form">Your sort code: </label></td>
          <!-- HTML pattern from nhahtdh at http://stackoverflow.com/questions/11341957/uk-bank-sort-code-javascript-regular-expression -->
          <td>
              <input
                id="sort-code"
                form="form"
                <?php // TODO: To remove maxlength="8" ?>
                name="sort-code"
                <?php // TODO: To remove pattern="^(?!(?:0{6}|00-00-00))(?:\d{6}|\d\d-\d\d-\d\d)$" ?>
                type="text"
                value="<?php echo( $user->getSortCode() ) ?>"
              />
          </td>
        </tr>
        <tr>
          <td><label for="account-number" form="form">Your account number: </label></td>
          <td>
            <input
              id="account-number"
              form="form"
              <?php // TODO: To remove maxlength="8" ?>
              name="account-number"
              type="text"
              value="<?php echo( $user->getAccountNumber() ) ?>"
            />
          </td>
        </tr>
      </table>
      <form action="staff-edit-details.php" id="form" method="POST">
        <button type="submit">Update your details</button>
      </form>
    </main>
  </body>
</html>
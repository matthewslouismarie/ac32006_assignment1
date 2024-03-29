<?php
/**
 * This method displays the head elements common to most pages.
 * It has to be called before the <title> element as it sets the charset.
 * 
 * @author Louis-Marie Matthews
 */
function displayHead() {
  ?>
  <meta charset="utf-8" />
  <link href="style.css" rel="stylesheet" type="text/css" />
  <?php
}



function displayLogOutForm() {
?>
<form method="post" action="login.php">
  <input type="hidden" name="log-out" value="true" />
  <button type="submit">Log out</button>
</form>
<?php
}



/**
 * This method displays in a table the given array using the given colums.
 * It also displays the given title.
 *
 * @author Louis-Marie Matthews
 */
function displayTable( $rows, $columns, $title ) {
  ?>
  <table class="bordered-table" >
  <caption><?php echo( $title ) ?></caption>
  <thead>
    <tr>
      <?php foreach ( $columns as $currentColumn ) : ?>
      <td><?php echo( $currentColumn ) ?></td>
      <?php endforeach ?>
    </tr>
    </thead>
    <?php foreach( $rows as $currentRow ) : ?>
    <tr>
	  <?php foreach ( $columns as $currentColumn ) : ?>
		<td><?php echo( $currentRow[ $currentColumn ] ) ?></td>
      <?php endforeach ?>
    </tr>
    <?php endforeach ?>
  </table>
  <?php
}



function displayPersons( $persons, $title ) {
	$columns = array(
	  'PersonId',
	  'UserId',
	  'FirstName',
	  'LastName',
	  'Address',
	  'Postcode',
	  'City',
	  'Telephone',
	  'Email'
	);
	displayTable( $persons, $columns, $title );
}



function displayBranchManagers( $persons, $title ) {
	$columns = array(
	  'PersonId',
	  'BranchManagerId',
	  'UserId',
	  'FirstName',
	  'LastName',
	  'Address',
	  'Postcode',
	  'City',
	  'Telephone',
	  'Email',
	  'BranchId',
	  'AccountNumber',
	  'SortCode'
	);
	displayTable( $persons, $columns, $title );
}



function displaySalesAssistants( $persons, $title ) {
	$columns = array(
	  'PersonId',
	  'SalesAssistantId',
	  'UserId',
	  'FirstName',
	  'LastName',
	  'Address',
	  'Postcode',
	  'City',
	  'Telephone',
	  'Email',
	  'BranchId',
	  'AccountNumber',
	  'SortCode'
	);
	displayTable( $persons, $columns, $title );
}



function displayCompanyManagers( $persons, $title ) {
	$columns = array(
	  'PersonId',
	  'CompanyManagerId',
	  'UserId',
	  'FirstName',
	  'LastName',
	  'Address',
	  'Postcode',
	  'City',
	  'Telephone',
	  'Email',
	  'AccountNumber',
	  'SortCode'
	);
	displayTable( $persons, $columns, $title );
}



function displayAccessDenied(  $message = 'You can\'t access this page',
                            $title = 'Access Denied' )
{
  displayMessagePage( $message, $title );
}



function displayUnknownError( $message = 'An unexpected error occured.',
                            $title = 'Unexpected Internal Error' )
{
  displayMessagePage( $message, $title );
}



/**
 * TO BE CALLED BEFORE ANY HTML OUTPUT.
 */
function displayMessagePage( $message, $title )
{
  ?>
  <!doctype html>
  <html>
    <head>
      <?php displayHead() ?>
      <title><?php echo( $title ) ?></title>
    </head>
    <body>
      <main>
        <h1><?php echo ( $title ) ?></h1>
        <p><?php echo( $message ) ?></p>
      </main>
    </body>
  </html>
  <?php
  die();
}



/**
 * This method displays a number-indexed array of strings as a list of errors.
 */
function displayErrors( $errors ) {
  if ( sizeof( $errors) !==0 ) {
    foreach ( $errors as $error ) {
      ?>
      <p class="error"><?php echo( $error ) ?></p>
      <?php
    }
  }
}



/**
 * Checks if the value whose name is the parameter has been sent via
 * the POST method.
 * 
 * @author Louis-Marie Matthews
 */
function getPost( $name ) {
  if ( isset( $_POST[ $name ] ) ) {
    return $_POST[ $name ];
  }
  else {
    return null;
  }
}



/**
 * This method returns the GET value with the specified name, or null
 * if it hasn't been set.
 *
 * @author Louis-Marie Matthews
 */
function getHttpGet( $name ) {
  if ( isset( $_GET[ $name ] ) ) {
    return $_GET[ $name ];
  }
  else {
    return null;
  }
}
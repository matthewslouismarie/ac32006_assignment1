<?php

require_once( 'classes/exceptions/IllegalFormatException.php' );

class SortCode
{
  private $sortCode;
  
  
  
  public final function __construct( $sortCode ) {
    $this->setSortCode( $sortCode );
  }
  
  
  
  /**
   * TODO: accept sort codes with digits separated by spaces
   */
  public final static function isValidSortCode( $candidate ) {
    $regex = '/^(?!(?:0{6}|00-00-00))(?:\d{6}|\d\d-\d\d-\d\d)$/';
    if ( preg_match( $regex, $candidate ) === 1 ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public final function setSortCode( $sortCode ) {
    if ( self::isValidSortCode( $sortCode ) ) {
      $this->sortCode = $sortCode;
    }
    else {
      throw new IllegalFormatException( 'invalid sort code', 9587 );
    }
  }
  
  
  
  public final function __toString() {
    return $this->sortCode;
  }
}
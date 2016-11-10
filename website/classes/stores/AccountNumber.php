<?php

class AccountNumber
{
  private $accountNumber;
  
  
  
  public final function __construct( $accountNumber ) {
    $this->set( $accountNumber );
  }
  
  
  
  public final function __toString() {
    return $this->  accountNumber;
  }
  
  
  
  public final function set( $accountNumber ) {
    if ( self::isValid( $accountNumber ) ) {
      $this->accountNumber = $accountNumber;
    }
    else {
      throw new DomainException( 'invalid account number' );
    }
  }
  
  
  
  public final static function isValid( $candidate ) {
    // TODO: remove whitespaces and non-braking spaces as well?
    // TODO: simplify this method with just a regex?
    $string = str_replace(' ', '', $candidate);
    if ( ctype_digit( $string ) & strlen( $string ) === 8 ) {
      return true;
    }
    else {
      return false;
    }
  }
}
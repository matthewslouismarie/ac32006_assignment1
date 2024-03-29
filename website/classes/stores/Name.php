<?php

require_once( 'classes/exceptions/IllegalFormatException.php' );

class Name
{
  private $name;
  
  
  
  public final function __construct( $name ) {
    $this->set( $name );
  }
  
  
  
  public final function set( $name ) {
    if ( self::isValid( $name ) ) {
      $this->name = $name;
    }
    else {
      throw new IllegalFormatException( 'Invalid Name: The name can not be longer than 255 characters.' );
    }
  }
  
  
  
  public final static function isValid( $string ) {
    if ( strlen( $string ) <= 255 ) {
      return true;
    }
    else {
      return false;
    }
  }
  
  
  
  public final function __toString() {
    return $this->name;
  }
}
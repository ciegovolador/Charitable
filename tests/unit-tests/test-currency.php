<?php

class Test_Charitable_Currency_Helper extends WP_UnitTestCase {
	
	private $currency_helper;

	function setUp() {
		parent::setUp();
		$this->charitable = charitable();
		$this->currency_helper = $this->charitable->get_currency_helper();		
		$this->set_currency_format( 'left' );
		$this->set_currency( 'AUD' );		
		$this->set_decimal_count( 2 );
		$this->set_decimal_separator( '.' );
		$this->set_thousands_separator( ',' );
	}

	function test_get_monetary_amount() {		
		$this->assertEquals( '&#36;60.00', $this->currency_helper->get_monetary_amount( 60 ) );
		$this->assertEquals( '&#36;60.00', $this->currency_helper->get_monetary_amount( '60' ) );
	}

	function test_sanitize_monetary_amount() {		
		$this->assertEquals( 60.00, $this->currency_helper->sanitize_monetary_amount( '60' ) );		
		$this->assertEquals( 10.50, $this->currency_helper->sanitize_monetary_amount( '10.50' ) );
		$this->assertEquals( 10000.00, $this->currency_helper->sanitize_monetary_amount( '10,000' ) );

		/* Switch separators */
		$this->set_decimal_separator( ',' );
		$this->set_thousands_separator( '.' );

		$this->assertEquals( 600.00, $this->currency_helper->sanitize_monetary_amount( '600,00' ) );
		$this->assertEquals( 6000.00, $this->currency_helper->sanitize_monetary_amount( '6.000' ) );
		$this->assertEquals( 12500.50, $this->currency_helper->sanitize_monetary_amount( '12.500,50' ) );
	}

	/**
	 * @expectedIncorrectUsage	Charitable_Currency::sanitize_monetary_amount
	 */
	function test_sanitize_monetary_amount_exception() {		
		$this->assertInstanceOf( 'WP_Error', $this->currency_helper->sanitize_monetary_amount( 10.50 ) );
	}
	
	function test_get_decimals() {
		$this->assertEquals( 2, $this->currency_helper->get_decimals() );	
		$this->set_decimal_count( 4 );
		$this->assertEquals( 4, $this->currency_helper->get_decimals() );
		$this->set_decimal_count( 2 );
	}
	
	function test_get_currency_formats() {
		$this->assertEquals( '%1$s%2$s', $this->currency_helper->get_currency_format() );	

		$this->set_currency_format( 'right-with-space' );		

		$this->assertEquals( '%2$s&nbsp;%1$s', $this->currency_helper->get_currency_format() );
		$this->assertEquals( '60.00&nbsp;&#36;', $this->currency_helper->get_monetary_amount('60') );
	}

	function test_currencies() {

		$this->set_currency_format( 'left' );

		$assertions = array(
			'AED' => 'د.إ',
			'BDT' => '&#2547;',
			'BRL' => '&#82;&#36;',
			'BGN' => '&#1083;&#1074;.',
			'AUD' => '&#36;',
			'ARS' => '&#36;',
			'USD' => '&#36;',
			'EUR' => '&euro;',
			'JPY' => '&yen;',
			'RUB' => '&#1088;&#1091;&#1073;.',
			'KRW' => '&#8361;',
			'TRY' => '&#8378;',
			'NOK' => '&#107;&#114;',
			'ZAR' => '&#82;',
			'CZK' => '&#75;&#269;',
			'MYR' => '&#82;&#77;',
			'DKK' => 'kr.',
			'HUF' => '&#70;&#116;',
			'IDR' => 'Rp',
			'INR' => 'Rs.',
			'ISK' => 'Kr.',
			'ILS' => '&#8362;',
			'PHP' => '&#8369;',
			'PLN' => '&#122;&#322;',
			'SEK' => '&#107;&#114;',
			'CHF' => '&#67;&#72;&#70;',
			'TWD' => '&#78;&#84;&#36;',
			'THB' => '&#3647;',
			'GBP' => '&pound;',
			'RON' => 'lei',
			'VND' => '&#8363;',
			'NGN' => '&#8358;',
			'HRK' => 'Kn',
			'AN_UNLISTED_VALUE' => ''
		);

		foreach ($assertions as $currency_code => $symbol ) {
			$this->set_currency( $currency_code );	

			$expected = sprintf( '%1$s%2$s', $symbol, '60.00');
			$this->assertEquals( $expected, $this->currency_helper->get_monetary_amount( '60' ) );
		}
	}

	/* --- Series of helper functions --- */

	private function set_option( $option, $value ) {
		$settings = get_option( 'charitable_settings' );
		$settings[$option] = $value;
		update_option( 'charitable_settings', $settings );
	}

	private function set_currency_format( $format ) {
		$this->set_option( 'currency_format', $format );
	}

	private function set_currency( $currency ) {
		$this->set_option( 'currency', $currency );
	}

	private function set_decimal_count( $count ) {
		$this->set_option( 'decimal_count', $count );
	}

	private function set_decimal_separator( $separator ) {
		$this->set_option( 'decimal_separator', $separator );
	}

	private function set_thousands_separator( $separator ) {
		$this->set_option( 'thousands_separator', $separator );
	}	
}

<?php
/*
 * We are now in a position to get additional LDAP info from the 
 * returned Zend\Ldap\Ldap object
 */

/*
$zf2Path = realpath(__DIR__ . '/../../ZF2/library');
include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array(
    'Zend\Loader\StandardAutoloader' => array('autoregister_zf' => true)));
*/
include __DIR__ . '/../init_autoloader.php';
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\Ldap as AuthAdapter;
use Zend\Ldap\Ldap as Ldap;
$username = 'cn=clark,ou=zf2widder,dc=company,dc=com';
$password = 'password';
$ldapConfig = array(
	'server1' => array(
		'host' 					=> 'ldap.company.com',
		'accountDomainName' 	=> 'company.com',
		'accountDomainNameShort'=> 'company',
		'accountCanonicalForm' 	=> Ldap::ACCTNAME_FORM_USERNAME,
		'username' 				=> $username,
		'password' 				=> $password,
		'baseDn' 				=> 'dc=company,dc=com',
		'bindRequiresDn' 		=> 'true',
	),
);

$authAdapter = new AuthAdapter($ldapConfig, $username, $password);
$authService = new AuthenticationService();
$attempt = $authService->authenticate($authAdapter);
if ($attempt->isValid()) {
	$ldapUser= $authAdapter->getLdap();
}

// More information on search parameters
/*
 * filter		= what object class are you looking for?  (objectclass=*) gives you all types
 * baseDn		= starting container in the LDAP tree
 * scope		= Ldap::SEARCH_SCOPE_BASE
						dc=company,dc=com
 * 				  Ldap::SEARCH_SCOPE_ONE 
						cn=admin,dc=company,dc=com
						ou=zf2widder,dc=company,dc=com
						ou=onlinemarket,dc=company,dc=com
 * 				  Ldap::SEARCH_SCOPE_SUB
						dc=company,dc=com
						cn=admin,dc=company,dc=com
						ou=zf2widder,dc=company,dc=com
						cn=clark,ou=zf2widder,dc=company,dc=com
						cn=doug,ou=zf2widder,dc=company,dc=com
						cn=guest,ou=zf2widder,dc=company,dc=com
						ou=onlinemarket,dc=company,dc=com
						cn=xchange,ou=onlinemarket,dc=company,dc=com
						cn=marilyn,ou=onlinemarket,dc=company,dc=com
						...
						cn=adminTwo,ou=zf2widder,dc=company,dc=com
						cn=adminOne,ou=onlinemarket,dc=company,dc=com
 */
$searchOptions = array(
	'filter' => '(objectclass=*)', 
	'baseDn' => 'dc=company,dc=com', 
	'scope'	 => Ldap::SEARCH_SCOPE_SUB,
);
$result = $ldapUser->searchEntries($searchOptions);
foreach ($result as $item) {
	echo '<p>' . $item['dn'];
	Zend\Debug\Debug::dump($item);
	echo "</p>\n";
}

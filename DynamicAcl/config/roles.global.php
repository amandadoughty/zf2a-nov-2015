<?php
// This needs to be copied to /config/autoload
// DO NOT CONFUSE GROUPS WITH ROLES
// if you want to associate a group with a role, use the GROUPS table in the Groups module
return array(
    'service_manager' => array(
        'services' => array(
            // 2015-03-19 DB
            // lists the roles and their labels
            // -- key = role
            // -- value = 'label => appears in dropdown menus; 'parent' => role(s) the key role inherits from
            'roles' => array(
                'guest'             => array('label' => 'Guest',               'parent' => array()),
                'outsideprintorder' => array('label' => 'Outside Print Order', 'parent' => array('guest')),
                'everyone'          => array('label' => 'Everyone',            'parent' => array('guest')),
                'businessoffice'    => array('label' => 'Business Office',     'parent' => array('everyone')),
                'prodman'           => array('label' => 'Product Management',  'parent' => array('everyone')),
                'ordman'            => array('label' => 'Order Management',    'parent' => array('everyone')),
                'reporting'         => array('label' => 'Reporting',           'parent' => array('everyone')), 
                'admins'            => array('label' => 'Admin',               'parent' => array('everyone')),
                'superadmin'        => array('label' => 'Super Admin',         'parent' => array('admins'))
                
            ),
        ),
    ),  
);

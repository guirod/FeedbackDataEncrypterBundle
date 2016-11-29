CrossKnowledge DataEncrypter Bundle
===============================

The CrossKnowledge/DataEncrypter aims to encrypt some data (array or string).

Installation
------------

Add the bundle to your project:
```bash
composer require crossknowledge/data-encrypter-bundle
```
Enable bundle in your kernel:
```php
class AppKernel	extends Kernel
{
  public function registerBundles()
  {
	  $bundles = array(
      ...
      new \CrossKnowledge\DataEncrypterBundle\CrossKnowledgeDataEncrypter(),
		);
    ...
```

Now, to encrypt data, you can use the following service in your controller:
```php
  $this->get('crossknowledge.data_encrypter')->encrypt($data, $key);
```

To decrypt data, you can use the following service in your controller:
```php
  $this->get('crossknowledge.data_encrypter')->decrypt($data, $key);
```

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE

About
-----

CrossKnowledgeDataEncryoterBundle is a [CrossKnowledge](https://crossknowledge.com) initiative.
See also the list of [contributors](https://gitlab.com/CrossKnowledge/DataEncrypterBundle/contributors).
A couple of "distribution" (travis,readme.md, etc..) files are inspired from FriendsOfSymfony/FOSUserBundle's.

Contributions
-------------

Contributions are more than welcome.
We will try to integrate them. As long as there is no BC, anything can be suggested.


Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/CrossKnowledge/DataEncrypterBundle/issues).

When reporting a bug, it may be a good idea to reproduce it in a basic project
built using the [Symfony Standard Edition](https://github.com/symfony/symfony-standard)
to allow developers of the bundle to reproduce the issue by simply cloning it
and following some steps.

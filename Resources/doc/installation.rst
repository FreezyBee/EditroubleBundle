Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

.. code-block:: bash

    $ composer require freezy-bee/editrouble-bundle
..

Step 2: Enable the Bundle
-------------------------

Then, enable the bundle by adding it to the list of registered bundles
in the ``app/AppKernel.php`` file of your project:

.. code-block:: php

    <?php
    // app/AppKernel.php

    // ...
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...

                new FreezyBee\EditroubleBundle\FreezyBeeEditroubleBundle(),
            );

            // ...
        }

        // ...
    }

..


Step 3: Set routes
------------------

.. code-block:: yaml

    # app/config/routing.yml

    editrouble:
        resource: '@FreezyBeeEditroubleBundle/Resources/config/routing.yml'

..

Step 4: Add JS file to base template
------------------------------------

.. code-block:: twig

    <body>
        ...
        {% include("FreezyBeeEditroubleBundle::includejsfiles.html.twig") %}
    </body>
..

Step 5: Update database schema
------------------------------

.. code-block:: bash

    $ php bin/console d:s:u --force
..


Step 6: Change user role and placeholder (optionally)
-----------------------------------------------------

You can add config section to config.yml

.. code-block:: yaml

    # app/config/config.yml

    freezy_bee_editrouble:
        role: ROLE_EDITOR # default is ROLE_ADMIN
        placeholder: 'Please fill this textarea...' # default is 'Zadejte text...'
..

Step 7: How to use it?
----------------------

`Using guide <https://github.com/FreezyBee/EditroubleBundle/blob/master/Resources/doc/using.rst>`_

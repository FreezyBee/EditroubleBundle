Installation
============

Step 1: Download the Bundle
---------------------------

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

.. code-block:: bash

    $ composer require freezy-bee/editrouble-bundle

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

                new FreezyBee\EditroubleBundle\EditroubleBundle(),
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
        resource: '@EditroubleBundle/Resources/config/routing.yml'

..

Step 4: Add JS file to base template
------------------------------------

.. code-block:: twig

    <body>
        ...
        {% include("EditroubleBundle::includejsfiles.html.twig") %}
    </body>
..

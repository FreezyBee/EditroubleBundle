Using guide
===========

Installation
------------

First install bundle and add routes + js file block - [installation](https://github.com/FreezyBee/EditroubleBundle/blob/master/Resources/doc/installation.rst).


How it works?
-------------

- Template extension is looking for content in php class array -> cache -> database.

- From database and cache script loads full namespace with specific locale. Locale is automatically loaded from Translator bundle.


Preview
-------

.. image:: https://raw.githubusercontent.com/freezybee/editroublebundle/master/Resources/doc/on.png
    :width: 100%

.. image:: https://raw.githubusercontent.com/freezybee/editroublebundle/master/Resources/doc/off.png
    :width: 100%


Examples
--------

Warning!!! There's no XSS protection. Admin can add XSS and so on...

.. code-block:: twig

    {# basic usage <namespace>.<name> #}
    {% editrouble namespace.name %}

    {% for i in 0..200 %}
        {# you can use template variables by '{var}' syntax - it is possible only for name #}
        {% editrouble namespace.name{i} %}
    {% endfor %}

    {# possible characters are [a-Z0-9_] #}
    {% editrouble namespace2.testName_hello123 %}
..

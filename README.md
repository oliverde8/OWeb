What's OWeb
====
OWeb is a simple to use PHP FrameWork based on MVC principles that has in mind this simple basics.

* Easyly Maintainable : We considere this as our main goal. IF each time you want to update/upgrade your website you need to recode everything that there is a problem. OWeb allows every part to work completely separately so you may update one without touching another. Far better it allows you to replace existing codes by your own without actually editing the orginal code. The AutoLoader will work around which is the file you want to use.
* Easy to use : You may be able to o wathever you want with some existing frameworks but you need to spend a lot of time for each small feature you want to add. With OWeb we try to give you a bunch of easy to use tools that you can extend later on but that you still can very easily use. You don't need special training to build a page in OWeb, basic PHP 5.3 understanding will be enought
* Re use existing codes : Usualy for each website you build you need a special directory. and you will rarely mix up the code of 2 completely different website. Well if using OWeb you may do so. I would even say I recomend it. Why? well you may have 1 forum on www.site1.com and 1 blog on www.site2.com. Normally they should have nothing to do, but they actually have many elements in commun.
* All the Database Connection & User connection and persmissions part.

    > A BBCode parser for forum post's and Blog comments
    > A Javasript page changing tool so that all the page isn't refreshed.
    > A live Chat.
    > Many more exemples can be found. You may be asking "but all this files it will be a nightmare". Well no, because OWeb differentiate what the developer see from what the user see. So you can organize all your files as you wish as a developper and then using Page's display it with a simple link. You will just use different Page's for your different websites to reorganize stuff according to the website.
* Extending without Changing : OWeb comes with a bunch of Extensions that allows DB connections, user connections and more. If you decide to re-wrte any of those, extensions because you would like to use OpenConection for users to connect you may do so without changing a single line in the existing controllers, pages and extensions. If you extend the existing user/connection extension and in the config ask the usage of your own connection extension, OWeb will make it work. When an old Controller asks for the user\connection extension the framework will give him the newer user\YourExtendedConnection.

## Key Features
* MVC Structure with a Page structure To diferentiate the Developper point of view from the users point of view. It also allows easier Debug.
* AutoLoader still needs to gain some fontionalities but is for the moment capable of doing anything thay you throught at it.
* Extension system Allows to extend oweb without changing ewisting source code. OWeb comes with a bunch of Extensions that allows DB connections, user connections and more. If you decide to re-wrte any of those, extensions because you would like to use OpenConection for users to connect you may do so without changing a single line in the existing controllers, pages and extensions. If you extend the existing user/connection extension and in the config ask the usage of your own connection extension, OWeb will make it work. When an old Controller asks for the user\connection extension the framework will give him the newer user\YourExtendedConnection.
* Simple Error Mangement If you do an error in your Controller or Template, OWeb will be able to show a nice error that won't scare away your visitors. Errors in Extensions or on Initialisation of controllers needs still to be worked.
* JQuery and JQUery UI support
* Add Headers in Views You can add js and css files in the header of the page even if you are coding the views and think that the header has already been displayed. Actually the header is generated last to allow a better code to be generated
* Appi and Extension mode That will allow you to create cool JS interaction with you web page withoud redeveloping PHP code. You will just concentrate about the js problems.
* Powerfull Configuration of different elements is very important. OWeb can be configured using a single .ini file but other extensions and controllers can be configuredusing using different .ini files or the same file. In the configuration files elements of configuration for different classes are well separeted so that they don't mix up
* Multi language support OWeb by default supports multi language. YOu don't need anythin to make it work. You just need to take it in considiration while developing new controlers or changing the template

# SansCMS

SansCMS is not a CMS, hence the name. SansCMS is merely a PHP + CSS framework to kickstart the development of a simple website. The primary aim of the project is to make it easier to have a simple portfolio website up and running without the hassle of having to code it from the ground up.

As a designer myself I think it's very valuable for a designer to know a thing or two about coding. SansCMS is an ongoing experiment that's been my excuse to better understand PHP and the server-side part of it. I've been using and improving the framework for my personal website for more than two years now, and figured it was about time the code would be open-source now.

Please feel free to contribute to the project, and to use the framework for your own project however you want.

## Demo

* [demo.sanscms.com](http://demo.sanscms.com) = Dedicated demo
* [thomweerd.com](http://thomweerd.com) = My personal website, also running on SansCMS

## Requirements

* PHP 5.4+
* Apache (access to .htaccess)

## Installation

1. Ensure your host meets the requirements mentioned above
2. Download the framework and upload it to your server using (S)FTP

## Customization: Pages

### Add a page

To add a page, simply create a new `example.php` file where "example" is the URL, and place it in the main directory. To make it appear in the header navigation, open `system/sections/header.php` and edit the `navigation()` array with a proper page title and the correct link: `'Example' => 'example'`. Every page needs to include just two lines of PHP in order to work correctly within the framework:
```
<?php require_once('config.php') ?>
	<!--page content goes here-->
<?php section('footer') ?>
```

Note that the `config.php` file required above needs to be written as `../config.php` when the page is inside a folder. Exceptions like this usually happen for templates. Another example is that folders require you to add a trailing slash to the URL in the navigation. Please see the section titled [Templates](#templates) below.

### Remove a page

To remove a page, remove the file from both the main directoy and the header or footer navigation. You can remove it from the navigation while keeping the file to keep it hidden.

## Customization: Styling

In order to change the styling of the framework, you can simply edit the stylesheet located in `assets/css/site.css`, if you want your version of the framework to be a bit more future proof I would suggest adding an additional file named `theme.css` and simply overwrite values from the main stylesheet. Make sure you include the extra stylesheet in `system/sections/header.php` too, after the main stylesheet.

## Templates

If you would like to know how to add or remove a regular text page, please see the section titled [Pages](#pages) under Customization.

### Blog

The blog template is the first template that consists of a folder as opposed to a single file. `blog/index.php` is the main page that you'll see by visiting `example.com/blog/`, `blog/single.php` however displays a single post from `blog/posts/` based on the URL. The `blog/img/` folder can be used to store images displayed in blog posts.

### Contact

I'm planning on making the contact form a module so it's easier to implement on any page, but for now it's arguably a template. Right now the framework utilizes float labels, an awesome idea from [Matt](https://dribbble.com/shots/1254439--GIF-Float-Label-Form-Interaction). The format is as follows:

```
<div class="float-label">
	<input type="name" name="name" class="required" placeholder="Name" />
	<label>Name</label>
</div>
```

* You can change `type="name"` to `type="email"` in the template above to have the input field check for a an inccorrectly typed email address.
* You can also change the type to `type="subject"` to automatically use the field's value as the email's subject line.
* You can add `class="required"` based on whether you want the field to be required to fill out.

### Portfolio

WIP

## Modules

### Dribbble

The Dribbble module is used to display recent shots on a page. In order to use the module you'll have to obtain an access token by registering an application at https://api.dribbble.com.

```
echo dribbble(array(
	'token' => 'xyz',
	'count' => 10,
	'column' => 50
));
```

Required parameters:

1. `token` = The Dribbble API requires an access token, get yours at https://api.dribbble.com

Possible parameters:

1. `count` = The amount of shots to display, defaults to 10, maximum is 50.
2. `column` = The column width of the photo (eg. 20, 25, 33, 50 or 100).

_Note: A username is not necessary as the access token is used to identify the associated user._

### Instagram

The Instagram module is used to display recent photos on a page. The Instagram API requires an access token. The following page explains well how to get your access token, as it's a bit of a workaround: http://jelled.com/instagram/access-token

```
echo instagram(array(
	'token' => 'xyz',
	'count' => 18,
	'column' => 33
));
```

Required parameters:

1. `token` = The Instagram API requires an access token.

Possible parameters:

1. `count` = The amount of shots to display, defaults to 10, maximum allowed by api is 20.
2. `column` = The column width of the photo (eg. 20, 25, 33, 50 or 100).

_Note: A username is not necessary as the access token is used to identify the associated user._

## Themes

WIP

## Tips

You can change the `.md` Markdown file extension in `system/system.php` in the `text()` function.

## Author

SansCMS is a little project initiated and maintained by [@thomweerd](https://twitter.com/thomweerd).
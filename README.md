bible-taxonomy
==============

A hierarchical taxonomy for associating a WordPress post with a Bible reference.

* *Contributors:* Júlio Reis
* *Tags:* Bible, custom taxonomy
* *Requires at least:* 3.0.0
* *Tested up to:* 3.8.1
* *Stable tag:* 0.0.1
* *License:* GPLv3
* *License URI:* [http://www.gnu.org/licenses/gpl-3.0.html](http://www.gnu.org/licenses/gpl-3.0.html) or see the included `LICENSE.txt` and `LICENSE.md`

Description
-----------

Registers a `bible` taxonomy.

It does not create book names or chapters.

If you want to associate a post with a chapter, you should insert it as a child of its respective book, e.g. if you want to associate Jeremiah 29 with a post, you create a term called “Jeremiah 29” and make it a child of “Jeremiah”. This is easily accomplished via the Bible taxonomy box, which works just like the Categories box.

It’s possible to create another level with verses, e.g.

* Jeremiah
	* Jeremiah 29
		* Jeremiah 29:4–7

This plugin doesn’t print anything. You can use anything that works with custom taxonomies.

### Tested with

* [Polylang](http://polylang.wordpress.com/) – just turn on translations for the `bible` taxonomy under _Settings > Languages > Settings > Custom taxonomies_

Installation
------------

1. Upload the `bible-taxonomy` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the ‘Plugins’ menu in WordPress
1. Go to _Posts > Bible Taxonomy_ to configure it if necessary

### Updates

This plugin works with `github-updater`: turn it on to get automatic update notices when a new version is published on GitHub.

### Translations

This plugin’s translations are managed via Transifex. To help out, please go to [https://www.transifex.com/projects/p/bible-taxonomy/](https://www.transifex.com/projects/p/bible-taxonomy/). Thank you!

Change log
----------

See [CHANGES.md](CHANGES.md)

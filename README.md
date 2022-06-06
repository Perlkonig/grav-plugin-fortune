# Fortune Plugin

***Abandonment Notice:** I'm afraid I simply don't have the time to maintain my Grav themes and plugins. Those interested in taking over should refer to the ["Abandoned Resource Protocol"](https://learn.getgrav.org/17/advanced/grav-development#abandoned-resource-protoc). Feel free to fork and replace. So long, and thanks for all the fish.*

The **Fortune** Plugin is for [Grav CMS](http://github.com/getgrav/grav). It will select a random quote from a folder containing [traditional "fortune" files](https://en.wikipedia.org/wiki/Fortune_(Unix)). There's [a demo](https://www.perlkonig.com/demos/fortune) on my personal website.

## Installation

Installing the Fortune plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install fortune

This will install the Fortune plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/fortune`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `fortune`. You can find these files on [GitHub](https://github.com/perlkonig/grav-plugin-fortune) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/fortune
	
> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) and the [Error](https://github.com/getgrav/grav-plugin-error) and [Problems](https://github.com/getgrav/grav-plugin-problems) to operate.

### Admin Plugin

If you use the admin plugin, you can install directly through the admin plugin by browsing the `Plugins` tab and clicking on the `Add` button. I personally don't use the admin plugin, and I don't know how to incorporate things like the command-line interface into it. Pull requests are warmly welcomed.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/fortune/fortune.yaml` to `user/config/plugins/fortune.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
data: 'user://data/fortunes'
```

Note that if you use the admin plugin, a file with your configuration, and named fortune.yaml will be saved in the `user/config/plugins/` folder once the configuration is saved in the admin.

* `enabled`: If set to false, the plugin will be disabled and won't execute.
* `data`: This is a *folder* containing as many fortune files as you want. By default it assumes you will create a `fortunes` folder under your `user/data` folder. But you can point elsewhere if you wish.

## Usage

### Adding & Indexing Fortunes

Fortune files are actually two files:

* The first is a plain text file (often without an extension) that contains multi-line quotes separated by lines containing only a percent symbol (`%`).

  ```
  Angels are very good at math. That's why they call them arc-angels.
    -- Steven Novella (The Skeptics Guide to the Universe)
  %
  There is no material safety data sheet for astatine. If there were, it would just be the word "NO" scrawled over and over in charred blood.
    -- Randall Munroe, "What If?"
  ```

* The second is a binary index file with the same name as the text file and a `.dat` extension.

There is a command-line interface for this plugin that will generate these `.dat` files for you. From the root folder of your Grav installation, type the following:

```bash
bin/plugin fortune index path/to/files
```

You can provide a single file name or point to a folder, in which case it will index (or reindex) all files in that folder (*not* recursively). This folder should only contain the text files and any pre-existing `.dat` files.

### Inserting Into Pages

The plugin exports a global Twig variable `fortune`. Simply insert it wherever you want. Here's what appears on [my demo page](https://www.perlkonig.com/demos/fortune), for example:

```markdown
twig_first: true
process:
    twig: true
never_cache_twig: true

---

You open the fortune cookie and find the following:

{{ fortune }}
```

If you use it in a page, you'll want `never_cache_twig` set to true if you want the quote to continually change. Otherwise the quote will get cached and not change. 

If you have any problems, let me know!

## Credits

This plugin relies on [a library created by Henrik Aasted Sorensen](http://www.aasted.org/quote/). Many thanks!


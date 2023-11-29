
TYPO3 Content Blocks GUI
========================

This extension provides a GUI for the TYPO3 Content Blocks extension.


# Contribution to this extension

You want to support us with this extension? Great! We are happy to get your help. Please contact us
via slack.typo3.org in the channel #cig-structuredcontent. We will add you to our team and you can
start contributing to this extension.

See also [our initiative page](https://typo3.org/community/teams/typo3-development/initiatives/structured-content/) for more information.


## Requirements

* [DDEV](https://ddev.readthedocs.io/en/stable/)

## Setup for Developement

1. Clone the repository: `git clone git@github.com:krausandre/content-blocks-gui.git .`
2. Setup will run automatically on `ddev start`

**Username and pasword for TYPO3 Backend in DDEV:**

* username: contentblocks
* password: TYPO3-Contentblocks-GUI-12

## Building the VueJS App

Single-shot: `ddev composer build`

Watch mode: `ddev composer build:watch`

Livereload (only the VueJS App):

`ddev composer build:serve` – The app is live-reloading on https://content-blocks-gui.ddev.site:5173

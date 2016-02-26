# MageHost_Cm_Cache_Backend
MageHost extended version of Colin Mollenhour's Cm_Cache_Backend_File and Cm_Cache_Backend_Redis

# Installation if you keep your Magento code in Git
* Install [Modman](https://github.com/colinmollenhour/modman)
* `cd` to your Magento root dir
* `test -d .modman || modman init`
* `modman clone --copy --force https://github.com/magehost/MageHost_Cm_Cache_Backend`
* Add `.modman` to your `.gitignore`

# Installation if you do not use Git
* Install [Modman](https://github.com/colinmollenhour/modman)
* `cd` to your Magento root dir
* `test -d .modman || modman init`
* `modman clone --force https://github.com/magehost/MageHost_Cm_Cache_Backend`

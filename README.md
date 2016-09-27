# MageHost_Cm_Cache_Backend
MageHost extended version of Colin Mollenhour's Cm_Cache_Backend_File and Cm_Cache_Backend_Redis

## Installation
* Install [Modman](https://github.com/colinmollenhour/modman)
* `cd` to your Magento root dir
* `test -d .modman || modman init`
* `modman clone --copy --force https://github.com/magehost/magehost_cm_cache_backend`
* `modman clone --copy --force https://github.com/colinmollenhour/Cm_Cache_Backend_File.git`
* `modman clone --copy --force https://github.com/colinmollenhour/Cm_Cache_Backend_Redis.git`
* If you keep your Magento code in Git: 
  * `rm -rf lib/Credis/.git`
  * Add `.modman` to your `.gitignore`
* Edit `app/etc/local.xml`: inside `<config><global>` add/update:<br /> `<cache><backend>MageHost_Cm_Cache_Backend_File</backend></cache>` or `MageHost_Cm_Cache_Backend_Redis`

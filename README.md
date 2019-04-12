# Mozo Den: Moster Collecting

Mozo Den is a moster collecting game designed for Web Developement II.  The main perpose of this project was to learn about utilizing PHP and SQL to create a website.

## Parts of the Websites

### The Den

The den is where all the Mozos live.  You can see them moving around on the screen.
![User Den](https://i.imgur.com/TiVH5aD.png)
Click them will take you to their profile.

### Moster Profile

Each Mozo has a small profile about they.  Currectly the profile shows the give name, species name, rarity, and collection date.
![Moster Profile](https://i.imgur.com/ziJFAFp.png)
All Mozo's collected can be viewed from your profile.

### Your Profile

Your profile list all the Mozos you currently own. It shows what they look like, what their name is, and what their species is.  Additionally, clicking on their image will take you to the moster profile.
![Your Profile](https://i.imgur.com/oThS3l5.png)
You can see how many Mozos that you've discovered from the bestiary.

### The Bestiary

The bestiary shows Mozo you have discovered plus Mozos you have yet to discover.  Mozo you have yet to discover have their information obscured.  Additionally, premium Mozos are also listed on this page.
![Bestiary](https://i.imgur.com/yduU3oX.png)
premium Mozos can be bought from the store.


### The Store

The store is mostly a mockup what includes a handful of premium Mozos (mozos that must be bought). 
![The Store]()
Information about premium Mozos and non-premium Mozos can be changed through the admin pages.

## The Admin Pages

The admin pages include two sets of webpages that can only be accessed via the adminastors of the website.  These webpages are the Edit Mozo page and Create New Mozo page

### Edit Mozo Page

This page shows all Mozos that exist in the database. It is separated into two parts: Free Mozos and Premium Mozos.  Free Mozos can have their `image`, `info`, and `rarity` changed.  Premium Mozos can have their `image`, `info`, `quantity`, and `price` changed.  Changing a premium Mozos `quantity` changes how many of that mozo are available for purchase. Changing a free Mozos `rarity` changes the odds of a player earning one.  `Rarity` can be a value from 1 to 5 (most common to rarest).
![Edit Mozos](https://i.imgur.com/knJuFOc.png)
A Mozo can be created from the Create New Mozo page.

### Create New Mozo Page

The last page to be featured here is the Create New Mozo page.  This page allows for the creation of new mozos. Even premium Mozos can be created from this page.
![Create New Mozo Page](https://i.imgur.com/nFhZkvd.png)
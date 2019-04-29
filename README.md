# Valkyrie Airlines
[![forthebadge](https://forthebadge.com/images/badges/ages-12.svg)](https://forthebadge.com)
[![forthebadge](https://forthebadge.com/images/badges/uses-badges.svg)](https://forthebadge.com)
[![forthebadge](https://forthebadge.com/images/badges/you-didnt-ask-for-this.svg)](https://forthebadge.com)

This repository houses the code for our project.

Expect frequent updates!<br>

## Guidelines
It will be imperative that you **edit only files you are assigned to**!<br>
If you edit someone else's file, _unless they're done with it_, you will cause a **merge conflict**.<br>
Merge conflicts mean two people tried to make changes to the same file, and if those changes overlap, someone has to manually fix it.

### Saving
If you have closed the project for the day and do not plan to change anything else, please commit and push your changes like you do on C9.<br>
Example of what it looks like when on C9:
```console
dylan:~/workspace (master) $ git add .
dylan:~/workspace (master) $ git commit -m "A helpful message about what you changed"
dylan:~/workspace (master) $ git push
```

### Resuming
When you open your project again, in case anyone has made changes, please update your local copy with `git pull`.<br>
This will ensure you have the latest code.

## Responsibilities
### Dylan
- [x] General site design, UI/UX
  - Search System
    - [ ] Filter by price
    - [ ] Date picker
    - [ ] Use real data
    - [ ] Lead to checkout process
- [x] Database management
- [x] PHP resources (DAO classes, framework)
- [x] General API (WIP but basically done)

### Chris & Jerry
- Admin page
  - [ ] Sign-in
  - [ ] Sign-out
  - [ ] Overall design (can use Bootstrap)
- Data management
  - [ ] Add objects
  - [ ] Delete objects
  - [ ] Update objects

### Junior
- Cart management
  - Test different ways to store user's cart data. You should probably only store the IDs of flights, and then ask the API for the details of each flight whenever necessary.
    - Could probably just use `localStorage.setItem("cart", JSON.stringify(listOfFlightIDs));`
- JavaScript interaction for pages, if needed
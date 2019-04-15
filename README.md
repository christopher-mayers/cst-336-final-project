# Valkyrie Airlines
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
- [ ] General site design, UI/UX
- [ ] Database management
- [ ] PHP resources (DAO classes, framework)

### Chris & Jerry
- Admin page
  - [ ] Sign-in
  - [ ] Sign-out
  - [ ] Overall design (can use Bootstrap)
- Data management
  - [ ] Add objects
  - [ ] Delete objects
  - [ ] Update objects
- General API
  - We will no doubt, using javascript or PHP, need to send requests to perform the above data management.<br>
  If you'd like to structure the API nicely, maybe look at the guidelines for REST APIs, and have one PHP api file for
  each database table (`flights.php`, `users.php`...). In each file change what the API does based on
  `$_SERVER["REQUEST_METHOD"]`.
    - `"GET"` should get all objects, and if `?id=` is given in the url/data, get just the object with that ID
    - `"POST"` should create a new object based on given data
    - `"PUT"` should update an existing object. This method requires some manual implementation, as `$_PUT` does not normally exist in PHP
    - `"DELETE"` should delete an object with the given ID

Dylan: I'll create a skeleton of the API so you guys can fill it in.

### Junior
- Cart management
  - Test different ways to store user's cart data. You should probably only store the IDs of flights, and then ask the API for the details of each flight whenever necessary.
    - Could probably just use `localStorage.setItem("cart", JSON.stringify(listOfFlightIDs));`
- JavaScript interaction for pages, if needed
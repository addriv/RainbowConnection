# Overview
Build a web site to find and manage connections between a large number of users.
A user is a person with a first and last name, a favorite color, and any number of connections to other users.  Connections are always mutual (ie bi-directional).

<p align="center">
  <img src="https://github.com/addriv/RainbowConnection/blob/master/preview.gif" width="600">
</p>

## Features

- [ ] Initial index page  
  - [X] Display list of users with 3 columns: full name, favorite color, comma separated list of connected users  
  - [X] Color favorite color text with relevant color  
  - [ ] Infinite pagination, display only 25 users and load 25 more upon scrolling down 
      * Unfinished, api response data paginated but not handled in front end.
- [ ] User show page  
  - [X] Title bar with user's full name and favorite color  
  - [X] Display list of connected users with 3 columns: full name, favorite color, remove button  
  - [X] Color favorite color text with relevant color    
  - [ ] Infinite pagination, display only 25 connected users and load 25 more upon scrolling down    
      * Unfinished, api response data paginated but not handled in front end.
  - [ ] Remove button functionality  
  - [ ] Dropdown on favorite color to update to new  
- [X] Test endpoint  
  - [X] Takes a userCount, clears database, re-populates with appropriate count of randomly generated names  
  - [X] Randomly generate favorite color  
  - [X] Randomly generate between 0-50 connections  

## Implementation Timeline

**Day 0:**
- [X] Ember.js tutorial
- [X] Laravel tutorial
- [X] Implementation plan

**Day 1:**
- [X] Laravel project initial setup
- [ ] Back end
  - [X] PostgreSQL migrations/schema
    - [X] Users
    - [X] UserConnections
  - [X] Seed database
  - [X] Models
    - [X] User
    - [X] UserConnection
  - [X] Laravel endpoints
    - [X] `users`
      - [X] `GET /api/users`
      - [X] `GET /api/users/:user_id`
  - [X] Laravel controllers
    - [X] `users_controller`
- [X] Front end
  - [X] Initial index page
    - [X] Ember routes - `/`
    - [X] Styling
  - [X] User show page
    - [X] Ember routes - `/:user_id`
    - [X] Styling

**Day 2:**
- [ ] Back end
  - [X] Laravel endpoints
    - [ ] `users`
      - [X] `POST /api/users/testdata`
      - [ ] `PATCH /api/users/:user_id`
    - [ ] `user_connections`
     - [ ] `DELETE /api/user_connections/:user_connection_id`
- [ ] Front end
  - [ ] User show page
    - [ ] Update favorite color functionality
    - [ ] Remove connection functionality

## Schema

### `users`
| column name         | data type | details                   |
|:--------------------|:---------:|:--------------------------|
| `id`                | integer   | not null, primary key     |
| `first_name`        | string    | not null                  |
| `last_name`         | string    | not null                  |
| `favorite_color`    | string    | not null                  |
| `created_at`        | datetime  | not null                  |
| `updated_at`        | datetime  | not null                  |

+ index on `[:first_name, :last_name], unique: false` 

### `user_connections`
| column name         | data type | details                        |
|:--------------------|:---------:|:-------------------------------|
| `id`                | integer   | not null, primary key          |
| `user_id`           | integer   | not null, indexed, foreign key |
| `connected_user_id` | integer   | not null, indexed, foreign key |
| `created_at`        | datetime  | not null                       |
| `updated_at`        | datetime  | not null                       |

+ `user_id` references `users`
+ `connected_user_id` references `users`
+ index on `[:user_id, :connected_user_id], unique: true`

## Routes

### API Endpoints

`users`
* `GET /api/users` - initial index page
* `GET /api/users/:user_id` - user show page
* `PATCH /api/users/:user_id` - update favorite color
* `POST /api/users/testdata` - test endpoint for populating db

`user_connections`
* `DELETE /api/user_connections/:user_connection_id` - delete connection

### Front End Routes

* `/` - intial index page
* `/:user_id` - user show page

## Packages
* `ember-infinity` - infinite pagination  
* `faker` - generate random names
* `barryvdh/laravel-cors` - allow CORS

- - - - 

## Requirements
1. Site should only use ajax beyond initial index page load
2. All endpoints should follow REST protocol
3. Site should be developed using Laravel PHP and Ember.js
4. Domain should be "www.rainbowconnection.com".  In osx/linux you can edit your /etc/hosts file to point this domain to your local instance (recommend homestead or laradock).
5. All lists should be displayed using "infinite pagination".  Any list with more than 25 results should be paginated in this way.  Upon scrolling down, an additional 25 results should load at a time.
6. Color options include all primary, secondary & tertiary colors
7. Anywhere a user's favorite color appears, the text should be colored corresponding to the value.
8. Code should be well documented with appropriate comments.
9. Please include a top-level README.md explaining your major architectural decisions.  Most important requirement is shipping on time, so if you have to make feature cuts or take shortcuts in order to finish, please explain what trade-offs you made and why you chose them.

## Initial View (www.rainbowconnection.com)
* Displays a list of all users with three columns: [full name], [favorite color], [comma-separated list of full names of all connections]
* Favorite color text should be colored with the relevant color
* User's full name, and each connection name should be clickable.  Clicking should take you to User View page.

## User View (www.rainbowconnection.com/[userid])
* Displays a title with this user's full name and favorite color
* Displays a list of all user's connections with three columns: [full name], [favorite color], [remove button]
* Clicking a list item's remove button should remove that connection and update the current view.
* Clicking on the favorite color of the current user in the title bar should give a drop-down selection of colors.  Selecting a new color should update the current user's color.

## Test Endpoint (POST www.rainbowconnection.com/testdata)
* PARAMS: userCount - Integer between 1 and 1000000
* This endpoint should clear the database, and populate it with a set of [userCount] users with randomly generated, human first and last names.
* Each user should have between 0 and 50 connections to other users.  These connections should be randomly generated.
* Each user should have a randomly generated favorite color.


# WordFind
> WordFind is an application that allows users to play word search puzzles created by other users.

## Supported Features

- Registration / Login capability using AJAX
- CRUD capability for puzzle creation
- Creation of puzzles restricted to registered users
- Update and deletion of puzzles restricted to admin and puzzle author
- Show / hide word list, borders, labels, and puzzle solutions
- Puzzle solutions restricted to registered users
- Search puzzles on metadata
- Copy / Paste puzzles into other programs using html2canvas
- Play puzzles

##  Supported Languages. 

- English
- Telugu
- Hindi (WIP)
- Malayalam (WIP)
- Gujarathi (WIP)

## Login on Localhost Instructions

Use the following instructions to log in to this app for development purposes on localhost.
1. Open file 'helpers/authentication.php'
2. Set $development_environment = true;
3. Adjust other variables to see what Word Find looks like when logged in or not logged in.
   - To see what the app looks like when not logged in:
     - $logged_in = false;
   - To see what the app looks like when logged in as a regular user:
     - $logged_in = true;
     - $admin, $super_admin, $author, $sponsor = false;
   - To see what the app looks like when logged in as an admin:
     - $logged_in, $admin = true;
     - $super_admin = false;
   - To see what the app looks like when logged in as a super-admin:
     - $logged_in, $super_admin = true;
   - To see what the app looks like when logged in as an author:
     - $logged_in, $author = true;
     - $admin, $super_admin, $sponsor = false;
   - To see what the app looks like when logged in as a sponsor:
     - $logged_in, $sponsor = true;
     - $admin, $super_admin, $author = false;

Note: Do _not_ upload 'helpers/authentication.php' to a live hosted website with $development_environment set to true.

## Future Enhancements

- batch processing - creation of 100 puzzles to PDF
- Integration with Google Analytics
- Pagination for index, categories, and search pages
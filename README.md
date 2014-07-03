Snelkoppeling
=============

Snelkoppeling is a fictional dating site created as a project for the VWO subject Computer Science together with three other students. The application gives users a list of matches based on previously answered questions.

### Setup

Just add the database structure to your own local database and change the mysqli_connect and the path to the home directory in config.php

  $mysqli = mysqli_connect(db_location, db_username, db_password, "snelkoppeling") or die(mysqli_error($connect));
  $main_path = "//localhost/......."; // path to home directory
### Version
Version 1.0 - The first release of Snelkoppeling.info

Version 2.0.1 - Full refactor of the algoritme so it runs much much faster

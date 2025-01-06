# Trip
 Full Stack PHP code with front end and backend 
 # Step No 1
 Firstly,I created three tables in my database named as MyTrips named as users,locations and trips
 # Step No 2
Users table contains id(Auto Increment),Name(Which is entered by user ),email,Password and Created_at .
This will help in storing data for all users who logged in and signed up 
# Step No 3
Locations table contains id name locations(drop down appeared in UI ) created_ at 
# Step No 4
Trip table contains id(Auto_increment),user_id regarding which user can see the data on dashboard location_id comping as a foreign key from location table members ,trip_date,lunch ,price and date of creation 
# Step No 5
I created multiple files including index.php main file,register.php,user.php,trip.php,Database.php(to create database connection),create-trip
# Step No 6
# Working 
First Screen will be of index.php that will show login.php which will ask for user details and check from users table in database if he/she is present then it will bring that to main dashboard
# Step No 7
if the user is not already present then it will ask for his/her details 
like Name,Email,password and UserName 
That data on Register will go in users table of database
# Step No 8
After successful register it will bring my user again to Login for more authentication ,if she/he is authenticated then it will bring my user to main dashborad showing Hi message with that respective name
# Step No 9 
My main dashboard contains Trip table which will ask for Trip name and show location which is coming through location_id from location table and user_id from users table so that a particular user can see only his/her data
# Step No 10 
Unique point is that we have a special lunch box check box when the user clicks on that check box it will increment 20$ so that is upon user need
# Step No 11
upon submitting user will see his/her data in a impressive CSS on dashboard 
# Step No 12
upon logout his/her session will get expired 
# Step 13 What you need to have this project
Just PHP installed on your VS code and 
Xampp locally set up 
and an energetic and committed mind set to do something unique
# Thanks!!!
# Five-minute demonstration and viva preparation

0:00-0:45 - Open the live course catalogue. Show the responsive navbar, course cards and live search. Explain that Bootstrap provides the grid and custom JavaScript filters the cards.

0:45-1:45 - Sign in as an administrator. Add a course; intentionally omit a required field once to show server validation. Edit the course and show the updated public listing. Explain the route, controller, model and Blade view involved.

1:45-2:45 - Sign out. Register as a visitor with a sample name, email and phone. Attempt the same email again for the same course. Explain normalisation, the validator's unique rule and the database composite unique constraint. Mention that the same email may register for a different course.

2:45-3:30 - Open an admin URL while signed out to show the login redirect. Explain the separate admin authorisation check and CSRF protection. Sign in and view registrations. Delete the temporary course if appropriate and explain the cascading relationship.

3:30-4:15 - Open /api/courses. Show HTTP 200 and the JSON list using browser developer tools. Explain GET as the read operation and why contact details are excluded.

4:15-5:00 - Show the Git repository, meaningful commits, migrations and automated test results. Point to the foreign key and unique constraint. Confirm the live URL.

Practice explaining:
- Why registrations.course_id is a foreign key and why a composite unique key is necessary.
- Why client validation is convenient but server validation is authoritative.
- Why an authenticated user is not automatically an administrator.
- Why passwords are hashed and why POST still needs HTTPS.
- How Laravel MVC connects a route to a database query and view.
- What happens to registrations when a course is deleted.
- How concurrent duplicate requests are stopped by the database constraint.
- How the API differs from a rendered Blade page.

Use sample data in the demonstration. Be ready to explain and change the code yourself.

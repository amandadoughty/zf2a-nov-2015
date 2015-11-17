For this exercise, we start with the simple guestbook.

* Navigate to http://yourvhost/csrf-test.
* This page will maliciously post a comment to the guestbook without any user interaction at all.
* Return to http://yourvhost/guestbook and see the comment that was left via a CSRF exploit.

Once you add a CSRF token to the form, it should no longer be vulnerable to this exploit.

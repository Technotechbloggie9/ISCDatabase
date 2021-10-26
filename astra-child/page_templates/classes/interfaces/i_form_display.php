<?php 
/*
NOTE:
loose hierarchy
  1.Form
    2.Subform (if any)
      3.elements
        4. required submit button
Forms may be multipart or standard,
Only the post action is allowed because of security
There may be various display formats which might change which formwrap
methods are used, and provide various levels of division

Dropdowns and textboxes may need to be prefilled, 
so there must be value representation for this to occur,
checked and unchecked tinyint boxes will make the recorded values 
more representative of what's in the database

The less basic the version of form represented, the harder it will 
be to build this class
*/
 ?>
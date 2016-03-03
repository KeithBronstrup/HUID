# USAGE
## Host Unique Identifier

This document is intended to explain common usage scenarios for Host Unique
Identifier. It is not intended to be an exhaustive list and only covers the most
common use cases.

### MySQL INSERT and SELECT Queries

As discussed under the Database Storage heading of
[CAVEATS.md](https://github.com/KeMBro2012/HUID/blob/master/docs/CAVEATS.md),
the recommended storage format for database storage is the 16 byte binary
representation, with the stated caveat that escaping binary data can be
problematic. The examples below illustrate the creation of a table using HUID as
its primary key, as well as how to properly `INSERT` into and query that table
to avoid potential performance issues and escaping-related errors.

##### Creating the Table

Use a `BINARY(16)` field for your HUID, as below:

```
CREATE TABLE `HUID_demo_database_`.`HUID_demo_table` (
  `huid` BINARY(16) NOT NULL,
  PRIMARY KEY (`huid`));
```

##### Inserting Records

While it is possible to directly `INSERT` binary data, an HUID like
`48554944277320617765736f6d652121` would need to be escaped, as the binary
representation of that hexadecimal value is the ASCII string `HUID's awesome!!`
which,in addition to being true, contains an apostrophe. Additionally, some
configurations might complain about, or refuse, binary data passed as an ASCII
string under certain circumstances. To work around both of these issues, use the
`UNHEX()` function:

```
INSERT INTO `HUID_demo_database_`.`HUID_demo_table`
  SET `huid` = UNHEX('48554944277320617765736f6d652121');
```

##### Querying the Table

The same applies to queries run against the table:

```
SELECT * FROM `HUID_demo_database_`.`HUID_demo_table`
  WHERE `huid` = UNHEX('48554944277320617765736f6d652121');
```

##### How _not_ to Query the Table

While using the `HEX()` function on the field being queried, rather than
`UNHEX()`ing the value _will_ work, it is much slower than the example above,
because the database must run the `HEX()` function on the `huid` column of every
row in the table, rather than `UNHEX()`ing the query value _once_. Look to the
example below for what _not_ to do:

```
SELECT * FROM `HUID_demo_database_`.`HUID_demo_table`
  WHERE HEX(`huid`) = '48554944277320617765736f6d652121';
```

-----
##### Copyright (c) 2016 Keith Bronstrup and Contributors

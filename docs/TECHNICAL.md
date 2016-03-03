# TECHNICAL DETAILS
## Host Unique Identifier

This document is intended to describe the Host Unique Identifier on a technical
level and explain some of the design decisions that went into its creation.

### How does HUID work?

A HUID is comprised of 5 fields
 1. 56 bits representing the number of seconds lapsed since 00:00:00 UTC,
    January 1, 1970
 2. 20 bits representing the number of microseconds lapsed in the current second
 3. 16 bits as a primary namespace
 4. 16 bits as a secondary namespace
 5. 20 bits as a random component

The 3rd and 4th fields can optionally be used as additional random components.
It is recommended that only one of these fields be used in this way and that
random components be kept as far to the right as possible.

HUID can be represented in several different ways:
 - As a 36 character string with fields separated by a hyphen:
   `33333333333333-44444-5555-6666-77777`
 - As a 32 character hexadecimal value with fields concatenated:
   `33333333333333444445555666677777`
 - As a 16 byte binary value: `3333333DDEUVfgww`

Of the above formats, the string is the most human-friendly, while the
hexadecimal value will be the easiest to work with for most applications and the
binary format will be ideal for most database and storage considerations. Which
format or formats you should use will depend greatly on your application, so
care should be taken to ensure use of the correct format(s). Review
[CAVEATS.md](https://github.com/KeMBro2012/HUID/blob/master/docs/CAVEATS.md) for
additional considerations.

--------------------------------------------------------------------------------
##### Copyright (c) 2016 Keith Bronstrup and Contributors

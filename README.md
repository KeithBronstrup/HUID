# HUID
## Host Unique Identifier

This README is intended to describe the Host Unique Identifier in-general and
provide a comparison of HUID to the various versions of UUID repository is
intended to house reference implementations in various languages.

#### The HUID specification has been finalized.
#### It can be considered stable enough for production use at this time.


### What is HUID?

A Host Unique Identifier (HUID) is a unique indentifier, similar to a
Universally Unique Identifier (UUID), with optimizations for use as an indexed
value or primary key.

### How is a HUID Like a UUID?

UUID and HUID are both object identifiers intended to reduce the likelihood of
multiple objects or records beign assigned the same identifier. Both consist of
5 fields and can be represented as a 36 character hyphen-delimited string, a 32
character hexadecimal value, or a 16 byte binary value. Use cases for UUID and
HUID are similar; one common use case is as a primary key to enable simultaneous
inserts into a distributes data store (such as an SQL database with multiple
masters) without risk of collision.

### What's Wrong with UUID?

There is nothing wrong with UUID _per-se_, but it doesn't do as much as it could
to prevent collisions and, for reasons mentioned below, is not well suited for
se in indexed fields, sich as a primary key. If your application is collision-
tolerant and the UUID will not be used in an indexed field (or `INSERT`
performance is not important), UUID is a fine choice.

The list below details what's wrong with UUID when used in applications that are
not collision-tolerant, or as a record ID that will be indexed, by version:

 - UUID v1 and v2
  - Because there is no random component, there is a high likelihood of
    collision is a high volume of UUIDs are generated
  - Because the leftmost field is the most volatile, these UUIDs are loosely-
    ordered, causing indexing slowdowns when inserting new records
   - v1: Leftmost field is the last 32 bits of a 60-bit 100-nanosecond
     resolution timestamp, which cycles roughly once every 7.16 seconds
   - v2: Leftmost field is the user's UID or GID; in addition to only being
     available on POSIX-compliant systems it is, for all practical intents,
     effectively random
 - UUID v3 and v5
  - These versions of UUID offer no protection against collision; though v5 uses
    a stronger hash, hash collisions are still possible and become more likely
    over time, as there is no time component to limit the collision window
  - Since hashes are effectively unordered, the entire UUID is extremely
    volatile (rather than just the leftmost field as with v1 and v2), causing
    indexing slowdowns when inserting new records
 - UUID v4
  - This version of UUID offers no protection against collision; the likelihood
    of a collision between 122 random bits becomes more likely over time, as
    here is no time component to limit the collision window
  - The requirement of 122 bits of entropy can quickly deplete the available
    entropy pool if a large number of UUIDs are needed
  - Being entirely random, the entire UUID is extremely
    volatile (rather than just the leftmost field as with v1 and v2), causing
    indexing slowdowns when inserting new records

### How is HUID Better?

The two leftmost fields are time components, with the leftmost being the least
volatile, cycling approximately once every 2.285 billion years and limiting the
indexing window to HUIDs generated within one second under ideal conditions. The
second field is a microsecond clock, limiting the collision window to HUIDs
created within the same microsecond (and with the same namespace values). The
3rd and 4th fields are available to be used as namespaces, to identify the host
and/or user for which the HIUD was generated. The 5th field is a random
component, the purpose of which is to reduce the likelihood of collision
(to 1:1048576) in the case that two HUIDs are generated with the same namespace
fields in the same microsecond. Additionally, one or both of the namespace
fields may also be repurposed as additional random component(s).

Due to the field ordering decisions made in the design of HUID, the indexing
window is effectively limited to one second, plus the widest time differential
between any two hosts generating HUIDs, plus network latency.

### Additional Documentation

For more non-language-dependent information, please review to contents of the
[docs directory](https://github.com/KeMBro2012/HUID/tree/master/docs):

 - [Technical Details](https://github.com/KeMBro2012/HUID/tree/master/docs/TECHNICAL.md)
 - [Usage](https://github.com/KeMBro2012/HUID/tree/master/docs/USAGE.md)
 - [Caveats](https://github.com/KeMBro2012/HUID/tree/master/docs/CAVEATS.md)
 - [FAQ](https://github.com/KeMBro2012/HUID/tree/master/docs/FAQ.md)

Language-dependent documentation can be found in the README.md in the reference
subdirectory for each language.

-----
##### Copyright (c) 2016 Keith Bronstrup and Contributors

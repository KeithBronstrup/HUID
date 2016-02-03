# HUID
## Host Unique Identifier

A Host Unique Identifier is a unique indentifier, similar to a Universally
Unique Identifier (UUID), with the added ability to identify the host that
generated a given record and, optionally, the data store entrypoint where the
record was first stored.

This README is intended to describe the HUID in-depth and this repository is
intended to house reference implementations in various languages.

### How does HUID work?

A HUID is comprised of a primary and secondary host ID, a random component, a
UNIX timestamp, and a microsecond count, in the format
`AAAA-BBB-CCCC-DDDDDDDDDDDDDD-EEEEEEE` where the components are as follows:

* __Segment A:__ 4 hexadecimal digits to identify the primary host, determined
and provided by the application.

* __Segment B:__ 3 hexadecimal digits to identify the secondary host, determined
and provided by the application. If no secondary host (such as a database server
or key store) is used, or it is note deemed beneficial to the application to
identify this host, thee digits may be used to extend the primary host ID.

* __Segment C:__ 4 random hexadecimal digits.

* __Segment D:__ 14 hexadecimal digits to represent the current UNIX timestamp,
allowing for 56 bits and the ability to represet over 2.25 billion years.

* __Segment E:__ 7 hedadecimal digits to represent the current microsecond.

### Is HUID really better than UUID? And if so, how?

In certain instances, HUID is superior to UUID; in many others, the two are
roughly equivalent; in a few, UUID is superior.

One common instance where HUID is superior is when you have multiple hosts
simultaneously writing to the same multi-master database. Using HUID for your
primary key allows one host to write to multiple database masters, or multiple
hosts to write to one or more database masters simultaneously, without risk of
colliding IDs. This is achieved by allowing the application to identify the host
creating the record in segment A and the database master the record is being
written to in segment B, so even if segments C, D, and E are identical, IDs
still differ.

In the above scenario, it would be possible for a one or more hosts to generate
colliding UUIDs when writing to multiple database masters, potentially breaking
database replication. Because HUID allows for identification of the originating
host and receiving database master, preventing such collisions.

### Advantages of HUID

* When using truly unique primary and secondary host IDs as specified, HUID
shrinks the ID collision window to records created on a single host in a single
microsecond. Compare to UUID where any two hosts may generate identical values
at any point in time. HUID can identify 65,536 primary hosts and 4,096 secondary
hosts, or 268,435,456 hosts if segments A and B are combined.

* Like UUID, HUID can be represented as a 36 character string, a 32 digit
hexadecimal number, or a 16 byte binary string.

* An individual host may use all 7 digits of segments A and B as its host ID, as
would be ideal in applications utilizing a data store with a single node
handling all write operations, providing a total of 268,435,456 possible
unique host IDs. Alternately, and ideal or applications which utilize a data
store with multiple write-enabled nodes, segment A can be used as the host ID,
with segment B being used to identify the node to which the data was written;
this allows for 65,536 unique host IDs and 4,096 unique node IDs.

* As the likelihood of two HUIDs created on the same host in the same
microsecond having the same random component in segment C is 1:65536, and
because it is highly unlikely that a single host will be able to generate
multiple HUIDs in a single microsecond, the probability of a collision is
infinitesimally small, considerably less likely than the probability of a UUID
collision.

* The use of 56 bits to represent the current timestamp ensures that the HUID
will work for a given application and host ID combination for 2,284,933,287.8
years before the overflow wraparound creates the potential for segments D and E
to be repeated for the same host ID pair. 

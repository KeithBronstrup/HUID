# HUID
## Host Unique Identifier

A Host Unique Identifier is a unique indentifier, similar to a Universally
Unique Identifier (UUID), with the added ability to identify the host that
generated a given record and, optionally, the data store entrypoint where the
record was first stored.

#### The HUID specification has been finalized.
#### It can be considered stable enough for production use at this time.

This README is intended to describe the HUID in-depth and this repository is
intended to house reference implementations in various languages.

### How does HUID work?

A HUID is comprised of a primary and secondary host ID, a random component, a
UNIX timestamp, and a microsecond count, in the format
`AAAAAAAAAAAAAA-BBBBBBB-CCCC-DDD-EEEE` where the components are as follows:

* __Component A:__ 14 hexadecimal digits to represent the current UNIX timestamp,
allowing for 56 bits and the ability to represet over 2.25 billion years.

* __Component B:__ 7 hedadecimal digits to represent the current microsecond.

* __Component C:__ 4 hexadecimal digits as a primary namespace, which can be used
to identify the host which generated the ID.

* __Component D:__ 3 hexadecimal digits as a secondary namespace, which can be
used to identify the host, user, or group for which the ID was created, as an
extension of the primary namespace, or as an additional random component.

* __Component E:__ 4 random hexadecimal digits.

### Is HUID really better than UUID? And if so, how?

In certain instances, HUID is superior to UUID; in many others, the two are
roughly equivalent; in a few, UUID is superior.

One common use-case where HUID is superior is writing to a multi-master
database. If two hosts insert records with the same primary key into two
different masters at the same time (or faster than replication occurs), the
collision will cause replication to fail and introduce data inconsistency.
Using UUID instead of an auto-incrementing field can reduce the likelihood of
such a collision, but using HUID can eliminate it altogether.

This is because UUID values (aside from UUIDv1 and v2) are based on a hash or
randomness, both of which are prone to random collisions; UUIDv1 and v2 do
include a host identifier and a time component, but they do not include a
random component, so time-based collisions are common. HUID values are based on
two time-based components, a primary namespace (host identifier), a secondary
namespace (which can extend the host identifier, identify a user, group, or
another host, or simply be stuffed with additional random bytes), and a random
component. This ensures that, as with UUIDv1 and v2, no two hosts in a properly
configured system will generate the same HUID, while providing additional
protection against time-based collisions on a given host.

Unlike some versions of UUID (v3-v5), the HUID is not intended to be
cryptographically secure, and should not be used in cryptographic applications.
If you need a cryptographically secure number, and not just a unique identifier,
UUID is, by far, a better choice than HUID. Likewise, if the ability to identify
the host which generated a given ID or record is undesired, HUID is not the right
choice for your application, as it is this ability which provides most of the
advantages of HUID.

Some of the advantages of HUID can be shoehorned into UUIDv3-v5, in violation of
the specifications, but doing so brings its own set of problems. For example, if
a developer, new to your project, sees that UUID is being used, but that the
implementation is nonstandard, they may take it upon themselves to "correct"
that implementation. Since collisions are exceedingly rare, it may be months,
years, or even decades before this is noticed, likely when a collision causes
your application to fail catastrophically. Using a spec which natively accounts
for per-host and per-user uniqueness prevents this possibility, by giving the
enterprising developer no out-of-spec implementation to "fix".

### Advantages of HUID

* Like UUID, HUID can be represented as a 36 character string, a 32 digit
hexadecimal number, or a 16 byte binary string.

* Similar to UUIDv1, HUID is intended to identify the host which generated the
ID and may identify the user, as done by UUIDv2, as well, by way of the
secondary namespace.

* HUID provides 268,435,456 namespaces, which may be divided into 65,536 primary
namespaces and 4,096 secondary namespaces.

* As with UUIDv1 and v2, HUID also has a strong time-based component, though
it differs by also including a random component, reducing the likelihood of
time-based collisions for which UUIDv1 and v2 are often avoided. 

* An individual host may utilize both namespace components to identify itself,
or it may use the first namespace component to identify itself and the second to
identify the user, group, or host for which the ID was created. Alternately, the
second namespace component may be used to introduce additional randomness,
providing further protection against time-based collisions.

* When utilizing both namespace components, the likelihood of two HUIDs generated
on the same host (and, potentially, those created _for_ a single user, group,
host) within the same microsecond (a near impossibility in itself) is 1:65,536,
due to the inclusion of a random component; this is an advantage over UUIDv1 and
v2. If the second namespace component is used as an additional source of
randomness, that likelihood drops to 1:268,435,456.

* The use of 56 bits to represent the current timestamp ensures that the HUID
will work for a given application and namespace pair for 2,284,933,287.8 years
before the overflow wraparound creates the potential for the time components to
be repeated.

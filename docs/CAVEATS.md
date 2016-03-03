# CAVEATS
## Host Unique Identifier

This document is intended to highlight best practices for using Host Unique
Identifiers in your project.

### Database Storage

One of HUID’s primary use cases is to serve as a replacement for UUID primary
keys in databases. A key reason for this is that UUID values conforming to
[RFC 4122](https://www.ietf.org/rfc/rfc4122.txt) are poorly ordered, resulting
in [extremely degraded database performance](http://kccoder.com/mysql/uuid-vs-int-insert-performance/)
when inserted into an indexed field, such as a primary key. To remedy this, HUID
was designed with the least volatile component, the timestamp, as the leftmost
field. While this does help speed things up by limiting the indexing window,
there is more that can be done to handle HUID more efficiently in your database.
This discussion will center primarily around MySQL, but most RBDMS and NoSQL
solutions should have equivalent functionality.

The string representation of the HUID is 36 characters, including 4 hyphens;
that's 36 bytes of string data, just for a record ID, which makes your indexes
larger, such that fewer records can be indexed in RAM. You can make a small dent
in this by using the hexadecimal format, which is 32 bytes, but a better
solution is to use the binary format, which is only 16 bytes, `BINARY(16)`. This
not only results in a reduction of more than 50% in the overall size of the
field and brings a massive reduction in the size of the index, it is much faster
in `INSERT`, `SELECT`, and other operations.

One caveat to this is that the data used in your queries must be carefully
escaped, lest your database confuse certain binary values for string-terminating
quotes. As a workaround, it is recommended that you use the `UNHEX()` function
(or your database's equivalent), along with the hexadecimal HUID format, to let
the database handle conversion to binary for storage.

It is worth noting, should you choose to use UUID rather than HUID for your
primary key, that the above advice regarding storage format applies equally to
both identifiers.

-----
##### Copyright (c) 2016 Keith Bronstrup and Contributors

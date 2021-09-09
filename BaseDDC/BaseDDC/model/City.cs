using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class City
    {
        public City()
        {
            People = new HashSet<People>();
        }

        public int Id { get; set; }
        public string Title { get; set; }
        public sbyte? Republic { get; set; }

        public ICollection<People> People { get; set; }
    }
}

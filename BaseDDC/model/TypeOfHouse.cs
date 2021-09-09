using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class TypeOfHouse
    {
        public TypeOfHouse()
        {
            Lead = new HashSet<Lead>();
            Profile = new HashSet<Profile>();
        }

        public int Id { get; set; }
        public string Title { get; set; }

        public ICollection<Lead> Lead { get; set; }
        public ICollection<Profile> Profile { get; set; }
    }
}

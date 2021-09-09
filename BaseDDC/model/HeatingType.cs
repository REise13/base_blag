using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class HeatingType
    {
        public HeatingType()
        {
            Profile = new HashSet<Profile>();
        }

        public int Id { get; set; }
        public string Title { get; set; }

        public ICollection<Profile> Profile { get; set; }
    }
}

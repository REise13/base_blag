using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class Need
    {
        public Need()
        {
            Crossneed = new HashSet<Crossneed>();
        }

        public int Id { get; set; }
        public string Title { get; set; }

        public ICollection<Crossneed> Crossneed { get; set; }
    }
}

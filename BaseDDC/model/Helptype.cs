using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class Helptype
    {
        public Helptype()
        {
            Help = new HashSet<Help>();
        }

        public int Id { get; set; }
        public string Title { get; set; }

        public ICollection<Help> Help { get; set; }
    }
}

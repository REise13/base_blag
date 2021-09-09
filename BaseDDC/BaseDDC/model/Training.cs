using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class Training
    {
        public Training()
        {
            Crosstraining = new HashSet<Crosstraining>();
        }

        public int Id { get; set; }
        public string Title { get; set; }

        public ICollection<Crosstraining> Crosstraining { get; set; }
    }
}

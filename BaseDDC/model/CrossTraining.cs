using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class Crosstraining
    {
        public int Id { get; set; }
        public int IdProfile { get; set; }
        public int IdTraining { get; set; }
        public DateTime? DateTraining { get; set; }

        public Profile IdProfileNavigation { get; set; }
        public Training IdTrainingNavigation { get; set; }
    }
}

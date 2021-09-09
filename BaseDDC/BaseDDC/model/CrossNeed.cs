using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class Crossneed
    {
        public int Id { get; set; }
        public int IdProfile { get; set; }
        public int IdNeed { get; set; }

        public Need IdNeedNavigation { get; set; }
        public Profile IdProfileNavigation { get; set; }
    }
}

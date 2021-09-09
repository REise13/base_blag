using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class Crosscategory
    {
        public int Id { get; set; }
        public int IdProfile { get; set; }
        public int IdCategory { get; set; }

        public Category IdCategoryNavigation { get; set; }
        public Profile IdProfileNavigation { get; set; }
    }
}

using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class Category
    {
        public Category()
        {
            Crosscategory = new HashSet<Crosscategory>();
        }

        public int Id { get; set; }
        public string Title { get; set; }

        public ICollection<Crosscategory> Crosscategory { get; set; }
    }
}

﻿using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class LeadReason
    {
        public LeadReason()
        {
            Lead = new HashSet<Lead>();
        }

        public int Id { get; set; }
        public string Title { get; set; }

        public ICollection<Lead> Lead { get; set; }
    }
}
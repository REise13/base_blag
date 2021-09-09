using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class Help
    {
        public int Id { get; set; }
        public int IdProfile { get; set; }
        public int IdHelptype { get; set; }
        public int IdProject { get; set; }
        public int IdDonor { get; set; }
        public DateTime? StartDate { get; set; }
        public DateTime? EndDate { get; set; }

        public Donor IdDonorNavigation { get; set; }
        public Helptype IdHelptypeNavigation { get; set; }
        public Profile IdProfileNavigation { get; set; }
        public Project IdProjectNavigation { get; set; }
    }
}

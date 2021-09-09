using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BaseDTO
{
    public class DTO_Help_Get
    {
        public int Id { get; set; }
        public DTO_Donor IdDonorNavigation { get; set; }
        public DTO_HelpType IdHelptypeNavigation { get; set; }
        public DTO_Profile_Get IdProfileNavigation { get; set; }
        public DTO_Project_Get IdProjectNavigation { get; set; }
        public DateTime? StartDate { get; set; }
        public DateTime? EndDate { get; set; }
    }

    public class DTO_Help_Add
    {
        public int Id { get; set; }
        public int IdProfile { get; set; }
        public int IdHelptype { get; set; }
        public int IdProject { get; set; }
        public int IdDonor { get; set; }
        public DateTime? StartDate { get; set; }
        public DateTime? EndDate { get; set; }
    }

    public class DTO_Help_Add_Edit
    {
        public int Id { get; set; }
        public string Title { get; set; }
        public int IdProfile { get; set; }
        public int IdHelptype { get; set; }
        public int IdProject { get; set; }
        public int IdDonor { get; set; }
        public DateTime? StartDate { get; set; }
        public DateTime? EndDate { get; set; }
    }
}

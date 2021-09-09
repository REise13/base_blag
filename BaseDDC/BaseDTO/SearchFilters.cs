using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace BaseDTO
{
    public class Fl_Profile_Info
    {
        public string sName { get; set; }
        public string Name { get; set; }
        public string Patr { get; set; }
        public int? min_age { get; set; }
        public int? max_age { get; set; }
        public int? id_City { get; set; }
        public int? id_Gender { get; set; }
        public List<int> id_Categories { get; set; }
        public string INN { get; set; }
        public string Passport { get; set; }
        public int? id_Project { get; set; }
        public int? id_Donor { get; set; }
    }

    public class Fl_Lead
    {
        public string Fio { get; set; }
        public string Phone { get; set; }
        public int IdReason { get; set; }
        public string FioNeed { get; set; }
        public string City { get; set; }
        public int IdTypeOfHouse { get; set; }
        public int IdBdistrict { get; set; }
        public int IdMigrant { get; set; }
        public int IdFamUnemp { get; set; }
        public sbyte Income { get; set; }
        public int IdFamily { get; set; }
        public int IdChild { get; set; }
        public sbyte Adopted { get; set; }
        public string Categories { get; set; }
        public string Need { get; set; }
        public sbyte Volunteer { get; set; }
        public DateTime Datelead { get; set; }
    }
}

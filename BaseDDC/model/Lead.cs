using System;
using System.Collections.Generic;

namespace BaseDDC.model
{
    public partial class Lead
    {
        public int Id { get; set; }
        public string Fio { get; set; }
        public string Phone { get; set; }
        public string Email { get; set; }
        public int? IdReason { get; set; }
        public string FioNeed { get; set; }
        public string City { get; set; }
        public string District { get; set; }
        public int? IdTypeOfHouse { get; set; }
        public int? IdBdistrict { get; set; }
        public int? IdMigrant { get; set; }
        public int? IdFamUnemp { get; set; }
        public sbyte? Income { get; set; }
        public int? IdFamily { get; set; }
        public int? IdChild { get; set; }
        public sbyte? Adopted { get; set; }
        public string Categories { get; set; }
        public string Need { get; set; }
        public sbyte? Volunteer { get; set; }
        public string Subcontact { get; set; }
        public DateTime? Datelead { get; set; }

        public LeadBdisctrict IdBdistrictNavigation { get; set; }
        public LeadChildrens IdChildNavigation { get; set; }
        public LeadFamUnemp IdFamUnempNavigation { get; set; }
        public LeadFamily IdFamilyNavigation { get; set; }
        public LeadMigrant IdMigrantNavigation { get; set; }
        public LeadReason IdReasonNavigation { get; set; }
        public TypeOfHouse IdTypeOfHouseNavigation { get; set; }
    }
}

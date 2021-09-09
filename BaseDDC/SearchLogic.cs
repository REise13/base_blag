using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using BaseDDC.model;
using BaseDTO;
using Microsoft.EntityFrameworkCore;
namespace BaseDDC
{
    public class ProfileSearchLogic
    {
        private baseddcContext Context;
        public ProfileSearchLogic()
        {
            Context = new baseddcContext();
        }

        public IQueryable<Profile> GetProfiles(Fl_Profile_Info searchmodel)
        {
            var result = Context.Profile.AsQueryable();

            if (searchmodel != null)
            {
                              
                if (!string.IsNullOrEmpty(searchmodel.sName))
                    result = result.Where(x => x.IdPeopleNavigation.SName.Contains(searchmodel.sName));
                if (!string.IsNullOrEmpty(searchmodel.Name))
                    result = result.Where(x => x.IdPeopleNavigation.Name.Contains(searchmodel.Name));
                if (!string.IsNullOrEmpty(searchmodel.Patr))
                    result = result.Where(x => x.IdPeopleNavigation.Patr.Contains(searchmodel.Patr));
                if (!string.IsNullOrEmpty(searchmodel.Passport))
                    result = result.Where(x => x.IdPeopleNavigation.Passport.Contains(searchmodel.Passport));
                if (!string.IsNullOrEmpty(searchmodel.INN))
                    result = result.Where(x => x.IdPeopleNavigation.Inn.Contains(searchmodel.INN));
                if (searchmodel.id_City.HasValue&& searchmodel.id_City>0)
                    result = result.Where(x => x.IdPeopleNavigation.IdCity == searchmodel.id_City);
                
                if (searchmodel.id_Gender.HasValue && searchmodel.id_Gender > 0)
                    result = result.Where(x => x.IdPeopleNavigation.IdGender == searchmodel.id_Gender);
                if (searchmodel.min_age.HasValue)
                    result = result.Where(x => (DateTime.Now.Year - x.IdPeopleNavigation.Year) >= searchmodel.min_age);
                if (searchmodel.max_age.HasValue)
                    result = result.Where(x => (DateTime.Now.Year- x.IdPeopleNavigation.Year) <= searchmodel.max_age);              
                if (searchmodel.id_Categories != null)
                    result = result.Where(x => x.Crosscategory
                    .Where(xx=>searchmodel.id_Categories.Contains(xx.IdCategory)==true).Count()==searchmodel.id_Categories.Count());

                if(searchmodel.id_Donor.HasValue&&searchmodel.id_Donor>0)
                {
                    result = result.Where(x => x.Help.Where(xx => xx.IdDonor == searchmodel.id_Donor).Count() > 0);
                }
                if (searchmodel.id_Project.HasValue && searchmodel.id_Project > 0)
                {
                    result = result.Where(x => x.Help.Where(xx => xx.IdProject == searchmodel.id_Project).Count() > 0);
                }


            }
            return result;
        }
    }

    public class LeadSearchLogic
    {
        private baseddcContext Context;
        public LeadSearchLogic()
        {
            Context = new baseddcContext();
        }

        public IQueryable<Lead> GetProfiles(Fl_Lead searchmodel)
        {
            var result = Context.Lead.AsQueryable();

            if (searchmodel != null)
            {

                if (!string.IsNullOrEmpty(searchmodel.Fio))
                    result = result.Where(x => x.Fio.Contains(searchmodel.Fio));
                if (!string.IsNullOrEmpty(searchmodel.Phone))
                    result = result.Where(x => x.Phone.Contains(searchmodel.Phone));
                if (searchmodel.IdReason>0)
                    result = result.Where(x => x.IdReason==searchmodel.IdReason);
                if (!string.IsNullOrEmpty(searchmodel.FioNeed))
                    result = result.Where(x => x.FioNeed.Contains(searchmodel.FioNeed));
                if (!string.IsNullOrEmpty(searchmodel.City))
                    result = result.Where(x => x.City.Contains(searchmodel.City));
                if (searchmodel.IdTypeOfHouse > 0)
                    result = result.Where(x => x.IdTypeOfHouse == searchmodel.IdTypeOfHouse);
                if (searchmodel.IdBdistrict > 0)
                    result = result.Where(x => x.IdBdistrict == searchmodel.IdBdistrict);
                if (searchmodel.IdChild > 0)
                    result = result.Where(x => x.IdChild == searchmodel.IdChild);
                if (searchmodel.IdFamily > 0)
                    result = result.Where(x => x.IdFamily == searchmodel.IdFamily);
                if (searchmodel.IdFamUnemp > 0)
                    result = result.Where(x => x.IdFamUnemp == searchmodel.IdFamUnemp);
                if (searchmodel.IdMigrant > 0)
                    result = result.Where(x => x.IdMigrant == searchmodel.IdMigrant);
                if (searchmodel.Income!=-1)
                    result = result.Where(x => x.Income==searchmodel.Income);
                if (searchmodel.Adopted != -1)
                    result = result.Where(x => x.Adopted == searchmodel.Adopted);
                if (searchmodel.Volunteer != -1)
                    result = result.Where(x => x.Volunteer == searchmodel.Volunteer);
                if (!string.IsNullOrEmpty(searchmodel.Categories))
                    result = result.Where(x => x.Categories.Contains(searchmodel.Categories));
                if (!string.IsNullOrEmpty(searchmodel.Need))
                    result = result.Where(x => x.Need.Contains(searchmodel.Need));
              


            }
            return result;
        }
    }
}

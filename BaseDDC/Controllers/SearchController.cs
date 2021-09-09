using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using BaseDDC.model;
using BaseDTO;
using Newtonsoft.Json;

namespace BaseDDC.Controllers
{
    [Route("Search")]
    [ApiController]
    public class SearchController : ControllerBase
    {
        public readonly baseddcContext _context = new baseddcContext();

        [Route("ProfileInfo")]
        [HttpPost]
        public IActionResult SProfileInfo([FromBody] DTO_Auth_Obj t)
        {
            Fl_Profile_Info filters;
            List<Profile> profiles = new List<Profile>();
            List<Rs_Profile_Info> results = new List<Rs_Profile_Info>();
            try
            {
                filters = JsonConvert.DeserializeObject<Fl_Profile_Info>(t.obj.ToString());
            }
            catch
            {
                return BadRequest("Не удаётся распознать полученный объект");
            }
            try
            {
                var searchlogic = new ProfileSearchLogic();
                var model = searchlogic.GetProfiles(filters);
                profiles = model.AsNoTracking().
                    Include(x=>x.IdPeopleNavigation).
                        ThenInclude(xx=>xx.IdCityNavigation).
                    Include(x => x.IdPeopleNavigation).
                        ThenInclude(xx=>xx.IdGenderNavigation).
                    Include(x=>x.Crosscategory).
                        ThenInclude(xx=>xx.IdCategoryNavigation).
                    Include(x=>x.Help).
                        ThenInclude(xx=>xx.IdDonorNavigation).
                    Include(x=>x.Help).
                        ThenInclude(xx=>xx.IdHelptypeNavigation).
                    Include(x => x.Help).
                        ThenInclude(xx => xx.IdProjectNavigation).
                    
                    ToList();
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message + "|| Не удалось отфильтровать содержимое базы");
            }
            try
            {
                foreach (Profile a in profiles)
                {
                    Rs_Profile_Info b = new Rs_Profile_Info();
                    b.FIO = a.IdPeopleNavigation.SName + " " + a.IdPeopleNavigation.Name + " " + a.IdPeopleNavigation.Patr;
                    b.Gender = a.IdPeopleNavigation.IdGenderNavigation.Title;
                    b.City = a.IdPeopleNavigation.IdCityNavigation.Title;
                    b.Age = Convert.ToString(DateTime.Now.Year - a.IdPeopleNavigation.Year);
                    b.Passport = a.IdPeopleNavigation.Passport;
                    b.INN = a.IdPeopleNavigation.Inn;
                    b.id_Profile = a.Id;
                    foreach (Crosscategory aa in a.Crosscategory)
                    {
                        b.Categories += aa.IdCategoryNavigation.Title + ";";
                    }
                    foreach (Help aa in a.Help)
                    {

                        b.Helps += aa.IdProjectNavigation.Title + "(" + aa.IdHelptypeNavigation.Title + "), " + aa.IdDonorNavigation.Title;
                        if (aa.StartDate != null)
                        {
                            b.Helps += ", " + Convert.ToDateTime(aa.StartDate).ToString("ddMMyy");
                            if (aa.EndDate != null) b.Helps += "-" + Convert.ToDateTime(aa.EndDate).ToString("ddMMyy");
                        }
                        b.Helps += " ; ";
                       
                    }
                    results.Add(b);
                }
                return Ok(results);
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }
        [Route("Lead")]
        [HttpPost]
        public IActionResult Leads([FromBody] DTO_Auth_Obj t)
        {
            Fl_Lead filters;
            List<Lead> leads = new List<Lead>();
            List<DTO_Lead_Get> results = new List<DTO_Lead_Get>();
            try
            {
                filters = JsonConvert.DeserializeObject<Fl_Lead>(t.obj.ToString());
            }
            catch
            {
                return BadRequest("Не удаётся распознать полученный объект");
            }
            try
            {
                var searchlogic = new LeadSearchLogic();
                var model = searchlogic.GetProfiles(filters);
                leads = model.AsNoTracking().
                   Include(x=>x.IdBdistrictNavigation).
                   Include(x => x.IdChildNavigation).
                   Include(x => x.IdFamilyNavigation).
                   Include(x => x.IdFamUnempNavigation).
                   Include(x => x.IdMigrantNavigation).
                   Include(x => x.IdReasonNavigation).
                   Include(x => x.IdTypeOfHouseNavigation).
                    ToList();
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message + "|| Не удалось отфильтровать содержимое базы");
            }
            try
            {
                if (leads.Count > 0)
                {
                    results = AutoMapper.Mapper.Map<List<Lead>, List<DTO_Lead_Get>>(leads);
                    return Ok(results);
                }
                else return BadRequest("Записи не найдены");
            }
            catch (Exception ex)
            {
                return BadRequest(ex.Message);
            }
        }

    }
}